<?php

use Carbon\Carbon;

$app->get('/admin/orders', $auth(true), $admin_staff(), function() use ($app) {

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

        $orders = $app->db->getAll('order', $query, $bindings);

        echo json_encode([
            "recordsTotal" => $orders->count(),
            "recordsFiltered" => $orders->count(),
            'data' => $orders->toArray(),
        ]);
        exit();
    }

    $app->render('admin/order/all.php');

})->name('admin_orders');

$app->get('/admin/order/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order) {

        //get order customer
        $customer = $app->db->get('customer', 'id=?', [$order->customer_id])->first();

        //get order address
        $address = $app->db->get('address', 'id=?', [$order->address_id])->first();

        //get product title and quantity unit price
        $products = $app->db->custom('SELECT orderproduct.quantity, orderproduct.unit_price, product.slug, product.title, orderproduct.unit_price * orderproduct.quantity as total FROM orderproduct JOIN product ON orderproduct.product_id = product.id WHERE orderproduct.order_id = ?', [$order->id]);

        $order->created_at = Carbon::parse($order->created_at)->format('M d, Y');
        $order->date = Carbon::parse($order->created_at);
 
        $app->render('admin/order/view.php', [
            'order' => $order,
            'customer' => $customer,
            'address' => $address,
            'products' => $products
        ]);

    } else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_order_view');

$app->get('/admin/order/shipped/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order && $order->status == "pending") {

        $app->db->update('order', $order->id, [
            'status' => 'shipped'
        ]);

        $app->flash('success', 'Order status updated');
        $app->response->redirect($app->urlFor('admin_order_view', ['number' => $number]));

    }else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_order_status');

$app->get('/admin/order/invoice/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order) {

         //get order address
        $address = $app->db->get('address', 'id=?', [$order->address_id])->first();
        //get order customer
        $customer = $app->db->get('customer', 'id=?', [$order->customer_id])->first();

        //get product title and quantity unit price
        $products = $app->db->custom('SELECT orderproduct.quantity, orderproduct.unit_price, product.title, orderproduct.unit_price * orderproduct.quantity as total FROM orderproduct JOIN product ON orderproduct.product_id = product.id WHERE orderproduct.order_id = ?', [$order->id]);

        $order->created_at = Carbon::parse($order->created_at)->format('M d, Y');
        $order->date = Carbon::parse($order->created_at);
 
        $app->render('admin/order/invoice.php', [
            'order' => $order,
            'products' => $products,
            'address' => $address,
            'customer' => $customer
        ]);

    } else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_order_invoice');

$app->get('/admin/order/cancel/:number', $auth(true), $admin_staff(), function($number) use ($app) {

    //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order && $order->status == "pending") {

        foreach ($order->ownOrderproduct as $oproduct) {

            $product = $app->db->get('product', 'id=?', [$oproduct['product_id']])->first();

            if ($product) {
                $app->db->update('product', $product->id, [
                    'quantity' => $product->quantity + $oproduct['quantity']
                ]);
            }
        }

        $app->db->update('order', $order->id, [
            'status' => 'canceled'
        ]);

        $app->flash('success', 'Order canceld, and quantity restored successful');
        $app->response->redirect($app->urlFor('admin_order_view', ['number' => $number]));

    }else {
        $app->flash('error', 'Order Number is invalid or Order is already shipped, canceld');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_order_cancel');