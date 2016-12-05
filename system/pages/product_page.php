<?php
$app->get('/product/:slug', function($slug) use ($app) {

    $product = $app->db->get('product', 'slug = ?', [$slug])->first();

    if ($product) {
        $app->render('product/product.php', [
            'product' => $product
        ]);
    } else {
        $app->flash('error', 'Product Not Found');
        $app->response->redirect($app->urlFor('home'));
    }
})->name('product');