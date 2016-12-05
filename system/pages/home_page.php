<?php

$app->get('/', function() use ($app) {

    $page = $app->request->get('page');
    $length = 9;
    $page = (isset($page) && is_numeric($page) ) ? $page : 1;
    $start = ($page-1) * $length;

    $products = $app->db->getAll('product', 'ORDER BY id DESC LIMIT ?, ?', [$start, $length]);
    $count = $products->count();

    $app->render('product/products.php', [
        'products' => $products->results(),
        'page' => $page,
        'pages' => ceil($count / $length)
    ]);

})->name('home');


$app->get('/test', function() use ($app) {


});