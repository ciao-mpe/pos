<?php

use Pos\Helpers\Validator\Forms\PoForm;
use Carbon\Carbon;

$app->get('/admin/purchaes/order', $auth(true), $admin_staff(), function() use ($app) {

    $app->pocart->refresh();

    $suppliers =  $app->db->getAll('supplier', 'ORDER BY id DESC')->results();

    $app->render('admin/purchases/order.php', [
        'suppliers' => $suppliers
    ]);

})->name('admin_purchases_order');

$app->post('/admin/purchaes/order', $auth(true), $admin_staff(), function() use ($app) {

    $app->pocart->refresh();

    if (!$app->pocart->total()) {
        $app->response->redirect($app->urlFor('admin_purchases_order'));
    }

    $request = $app->request;

    $suppliers =  $app->db->getAll('supplier', 'ORDER BY id DESC')->results();

    $errors = null;

    $v = $app->validator->validate(PoForm::rules(), PoForm::lables());

    if($v->validate()) {

        $po = $app->db->insert('po', [
            'number' => $app->hash->orderNumber(true),
            'date' => $request->post('date'),
            'total' => $app->pocart->total(),
            'supplier_id' => $request->post('supplier'),
            'stock' =>  ($request->post('stock') && $request->post('stock') == 'on') ? 1 : 0
        ]);

        $po_id = $po->lastInsertid();

        foreach ($app->pocart->all() as $product) {
            $app->db->insert('poproduct',[
                'po_id' => $po_id,
                'product_id' => $product->id,
                'quantity' => $product->order_quantity,
                'unit_price' => $product->price
            ]);

            if ($request->post('stock') && $request->post('stock') == 'on') {
                $app->db->update('product', $product->id, [
                    'quantity' => $product->quantity + $product->order_quantity
                ]);
            }
        }
        $app->pocart->clear();

        //flashing message and redirecting to the Purchases
        $app->flash('success', 'Purchase Order Placed Successful');
        $app->response->redirect($app->urlFor('admin_purchases'));

    } else {
        $errors = $v->errors();
    }

    $app->render('admin/purchases/order.php', [
        'suppliers' => $suppliers,
        'errors' => $errors,
        'request' => $request
    ]);

});

$app->get('/admin/purchaes/order/products/add/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $request = $app->request;
    $product = $app->db->getByid('product', $id)->first();

    if($app->pocart->has($product->id)) {
        $product->reorder = $app->pocart->get($product->id)['quantity'];
    }

    if ($product) {

        $app->render('admin/purchases/order_add.php', [
            'product' => $product,
            'update' => ($request->get('update') && $request->get('update') == "true") ? true : false
        ]);
        
    } else {
        $app->flash('error', 'Product id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_purchases_order_add');

$app->post('/admin/purchaes/order/products/add/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $request = $app->request;
    $product = $app->db->getByid('product', $id)->first();

    if ($product) {

        $quantity = $product->reorder;

        if ($request->post('quantity') && $request->post('quantity') != 0) {
            $quantity = $request->post('quantity');
        }
        $app->pocart->add($product->id, $quantity);

        $app->response->redirect($app->urlFor('admin_purchases_order'));

    } else {
        $app->flash('error', 'Product id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

});

$app->get('/admin/purchaes/order/products/delete/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $app->pocart->remove($id);
    $app->flash('success', 'Product removed');
    $app->response->redirect($app->urlFor('admin_purchases_order'));

})->name('admin_purchases_order_delete');

$app->get('/admin/purchaes/order/clear', function() use ($app) {

    $app->pocart->clear();
    $app->response->redirect($app->urlFor('admin_purchases_order'));

})->name('admin_purchases_order_clear');

$app->get('/admin/purchaes', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    if ($request->isAjax()) {

        $start = 0;
        $length = 10;
        $order_number = $request->get('columns')[0]['search']['value'];
        $query = "";
        $bindings = [];

        if ($request->get('start')) {
            $start = $request->get('start');
        }
        if ($request->get('length')) {
            $length = $request->get('length');
        }

        if($order_number != NULL) {
            $query = "number = ?";
            $bindings = [$order_number];
        }else {
            $query = "ORDER BY id DESC LIMIT ".$start.", ".$length;
        }

        $orders = $app->db->getAll('po', $query, $bindings);

        echo json_encode([
            "recordsTotal" => $orders->count(),
            "recordsFiltered" => $orders->count(),
            'data' => $orders->toArray(),
        ]);
        exit();
    }

    $app->render('admin/purchases/all.php');

})->name('admin_purchases');

$app->get('/admin/purchaes/order/view/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get purchase order
    $order = $app->db->get('po', 'number=?', [$number])->first();

    if ($order) {

        //get supplier
        $supplier = $app->db->get('supplier', 'id=?', [$order->supplier_id])->first();

        //get product title and quantity unit price
        $products = $app->db->custom('SELECT poproduct.quantity, poproduct.unit_price, product.slug, product.title, poproduct.unit_price * poproduct.quantity as total FROM poproduct JOIN product ON poproduct.product_id = product.id WHERE poproduct.po_id = ?', [$order->id]);

        $order->date = Carbon::parse($order->date)->format('M d, Y');
 
        $app->render('admin/purchases/order_view.php', [
            'order' => $order,
            'supplier' => $supplier,
            'products' => $products
        ]);

    } else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_purchases_order_view');


$app->get('/admin/purchaes/order/stock/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get order
    $order = $app->db->get('po', 'number=?', [$number])->first();

    if ($order && $order->stock == 0) {

        $app->db->update('po', $order->id, [
            'stock' => 1
        ]);

        foreach ($order->ownPoproduct as $poproduct) {
          $product = $app->db->get('product', 'id=?', [$poproduct['product_id']])->first();
          if ($product) {
               $app->db->update('product', $product->id, [
                  'quantity' => $product->quantity + $poproduct['quantity']
               ]);
            }
        }

        $app->flash('success', 'Purchase order marked as stock received');
        $app->response->redirect($app->urlFor('admin_purchases_order_view', ['number' => $number]));

    }else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_purchases_order_stock');