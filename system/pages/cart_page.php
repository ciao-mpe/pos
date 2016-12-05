<?php

$app->get('/cart', $customer(), function() use ($app) {
    $app->basket->refresh();
    $app->render('cart/cart.php');
})->name('cart');

$app->post('/cart/add/:slug', $customer(), function($slug) use ($app) {

    $request = $app->request;
    $product = $app->db->get('product', 'slug = ?', [$slug])->first();

    if ($product) {
        
        try {
            $quantity = 1;

            if ($request->post('quantity') && $request->post('quantity') != 0) {
                $quantity = $request->post('quantity');
            }
            $app->basket->add($product, $quantity);

            $app->response->redirect($app->urlFor('cart'));

        }catch (Exception $e) {
          $app->flash('error', $e->getMessage());
          $app->response->redirect($app->urlFor('product', ['slug' => $slug]));
        }

    } else {
        $app->flash('error', 'Product Not Found');
        $app->response->redirect($app->urlFor('products'));
    }

})->name('cart_add');

$app->post('/cart/update/:slug', $customer(), function($slug) use ($app) {

    $request = $app->request;
    $product = $app->db->get('product', 'slug = ?', [$slug])->first();

    if ($product) {

        try {
            $app->basket->update($product, $request->post('quantity'));
            $app->flash('success', 'Cart updated');
            $app->response->redirect($app->urlFor('cart'));

        }catch (Exception $e) {
          $app->flash('error', $e->getMessage());
          $app->response->redirect($app->urlFor('cart'));
        }

    } else {
        $app->flash('error', 'Product Not Found');
        $app->response->redirect($app->urlFor('products'));
    }

})->name('cart_update');

$app->get('/cart/delte/:id', $customer(), function($id) use ($app) {

    $app->basket->remove($id);
    $app->flash('success', 'Product removed');
    $app->response->redirect($app->urlFor('cart'));

})->name('cart_delete');

$app->get('/cart/clear', $customer(), function() use ($app) {

    $app->basket->clear();
    $app->response->redirect($app->urlFor('cart'));

})->name('cart_clear');