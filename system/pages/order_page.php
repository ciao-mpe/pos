<?php

use Pos\Helpers\Validator\Forms\OrderForm;
use Carbon\Carbon;

$app->get('/order', $customer(), function() use ($app) {

    $app->basket->refresh();

    if (!$app->basket->total()) {
      $app->response->redirect($app->urlFor('cart'));
    }
    if ($app->auth) {
        $app->render('order/order.php', [
            'user' => $app->auth,
            'customer' => $app->customer,
            'address' => (array_key_exists('ownAddress', $app->customer)) ? $app->customer['ownAddress'][0] : NULL
        ]);
    } else {
        $app->render('order/order.php');
    }

})->name('order');

$app->post('/order', $customer(), function() use ($app) {

    $request = $app->request;
    $app->basket->refresh();

    if (!$app->basket->total()) {
      $app->response->redirect($app->urlFor('cart'));
    }

    // all errors
    $errors = null;

    $v = $app->validator->validate(OrderForm::rules(), OrderForm::lables());

    if($v->validate()) {

        //order number
        $order_number = $app->hash->orderNumber();
        $password = randomPassword();

        //create user
        $user = $app->db->insert('user', [
            'email' => $request->post('email'),
            'password' => $app->hash->passwordHash($password),
        ]);
        $user_id = $user->lastInsertid();

        //create user permission
        $app->db->insert('permission', [
            'customer' => 1,
            'user_id' => $user_id
        ]);

        //create customer
        $customer = $app->db->insert('customer', [
            'first_name' => $request->post('first_name'),
            'last_name' => $request->post('last_name'),
            'user_id' => $user_id
        ]);
        $customer_id = $customer->lastInsertid();

        //create addresss
        $address = $app->db->insert('address', [
            'address1' => $request->post('address1'),
            'address2' => $request->post('address2'),
            'city' => $request->post('city'),
            'postal_code' => $request->post('postal_code'),
            'telephone' => $request->post('telephone'),
            'customer_id' => $customer_id
        ]);
        $address_id = $address->lastInsertid();

        //create order
        $order = $app->db->insert('order', [
            'number' => $order_number,
            'total' => $app->basket->total(),
            'address_id' => $address_id,
            'customer_id' => $customer_id,
            'status' => 'pending',
            'created_at' => Carbon::now()
        ]);
        $order_id = $order->lastInsertid();

        //create order products one by one
        foreach ($app->basket->all() as $product) {
            $app->db->insert('orderproduct',[
                'order_id' => $order_id,
                'product_id' => $product->id,
                'quantity' => $product->order_quantity,
                'unit_price' => $product->price
            ]);
        }

        //update product quantity
        foreach ($app->basket->reduceQuantity() as $product) {
            $app->db->updateObj($product);
        }

        //clear basket
        $app->basket->clear();

        $_SESSION['auth'] = $user_id;

        //sending an email to the user with order and account informations
        $app->mail->setTo($request->post('email'), $request->post('first_name').' '.   $request->post('last_name'))
         ->setSubject('Order Placed Success')
         ->setFrom('no-reply@lucids.info', 'lucids.info')
         ->addMailHeader('Reply-To', 'no-reply@lucids.info', 'lucids.info')
         ->addMailHeader('Cc', '', '')
         ->addMailHeader('Bcc', '', '')
         ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
         ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
         ->setMessage('<h3>Order Information</h3><hr><br><p>The Order Number is : <b>'.$order_number.'</b></p> <br> <h3>Account Information</h3><hr><br><p>Your Login Email :'.$request->post('email').'<p><p>Your Login Password : '.$password)
         ->setWrap(500);
        $app->mail->send();

        //flashing message and redirecting tot the home
        $app->flash('success', 'Order Placed Success');
        $app->response->redirect($app->urlFor('order_all'));

    } else {
        $errors = $v->errors();
    }

    $app->render('order/order.php', [
        'request' => $request,
        'errors' => $errors
    ]);
});

$app->post('/order2', $customer(), function() use ($app) {

    $request = $app->request;
    $app->basket->refresh();

    if ($request->post('address')) {
    
        $order_number = $app->hash->orderNumber();

        $address = $app->db->get('address', 'id=?', [$request->post('address')])->first();

        if($address && $address->customer_id == $app->customer['id']){

            //create order
            $order = $app->db->insert('order', [
                'number' => $order_number,
                'total' => $app->basket->total(),
                'address_id' => $address->id,
                'customer_id' => $app->customer['id'],
                'status' => 'pending',
                'created_at' => Carbon::now()
            ]);
            $order_id = $order->lastInsertid();

            //create order products one by one
            foreach ($app->basket->all() as $product) {
                $app->db->insert('orderproduct',[
                    'order_id' => $order_id,
                    'product_id' => $product->id,
                    'quantity' => $product->order_quantity,
                    'unit_price' => $product->price
                ]);
            }

            //update product quantity
            foreach ($app->basket->reduceQuantity() as $product) {
                $app->db->updateObj($product);
            }

            //clear basket
            $app->basket->clear();

            $app->flash('success', 'Order Placed Success');
            $app->response->redirect($app->urlFor('order_all'));

        } else {
            $app->flash('error', 'Address is invaid');
            $app->response->redirect($app->urlFor('order'));
        }

    } else {
        $app->flash('error', 'Address is invaid');
        $app->response->redirect($app->urlFor('order'));
    }


})->name('order_with_auth');


$app->get('/orders/:number',  $auth(true), $customer(), function($number) use ($app) {

     //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order) {

        $customer = $app->db->get('customer', 'id=?', [$order->customer_id])->first();

        if($customer->user_id == $app->auth->id){

            $products = $app->db->custom('SELECT orderproduct.quantity, orderproduct.unit_price, product.slug, product.title, orderproduct.unit_price * orderproduct.quantity as total FROM orderproduct JOIN product ON orderproduct.product_id = product.id WHERE orderproduct.order_id = ?', [$order->id]);

            $order->created_at = Carbon::parse($order->created_at)->format('M d, Y');
            $order->date = Carbon::parse($order->created_at);
     
            $app->render('/order/view.php', [
                'order' => $order,
                'products' => $products
            ]);

        } else {
            $app->flash('error', 'Order Number is invalid');
            $app->response->redirect($app->urlFor('home'));
        }

    } else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('home'));
    }

})->name('order_view');

$app->get('/orders', $auth(true), $customer(), function() use ($app) {

    $page = $app->request->get('page');
    $length = 10;
    $page = (isset($page) && is_numeric($page) ) ? $page : 1;
    $start = ($page-1) * $length;

    $orders = $app->db->getAll('order', "customer_id = ? ORDER BY id DESC LIMIT ?, ?", [$app->customer['id'], $start, $length]);
    
    $count = $orders->count();

    $app->render('order/orders.php', [
        'orders' => $orders->results(),
        'page' => $page,
        'pages' => ceil($count / $length)
    ]);

})->name('order_all');

$app->get('/orders/invoice/:number', $auth(true), $customer(), function($number) use ($app) {

    //get order
    $order = $app->db->get('order', 'number=?', [$number])->first();

    if ($order && $order->customer_id == $app->customer['id'] && $order->status == "shipped") {

        $order->created_at = Carbon::parse($order->created_at)->format('M d, Y');
        $order->date = Carbon::parse($order->created_at);

        //get product title and quantity unit price
        $products = $app->db->custom('SELECT orderproduct.quantity, orderproduct.unit_price, product.title, orderproduct.unit_price * orderproduct.quantity as total FROM orderproduct JOIN product ON orderproduct.product_id = product.id WHERE orderproduct.order_id = ?', [$order->id]);

        //get order address
        $address = $app->db->get('address', 'id=?', [$order->address_id])->first();
        //get order customer
        $customer = $app->db->get('customer', 'id=?', [$order->customer_id])->first();
 
        $app->render('order/invoice.php', [
            'order' => $order,
            'products' => $products,
            'address' => $address,
            'customer' => $customer
        ]);

    } else {
        $app->flash('error', 'Order Number is invalid');
        $app->response->redirect($app->urlFor('home'));
    }

})->name('order_invoice');

