<?php

$app->get('/admin', $auth(true), $admin_staff(), function() use ($app) {

    $orders = $app->db->getAll('order', "ORDER BY id DESC LIMIT ?, ?", [0, 5] );

    $customers = $app->db->custom("SELECT customer.id, concat(customer.first_name, ' ' ,customer.last_name) as name, user.email FROM customer JOIN user ON customer.user_id = user.id JOIN permission ON customer.user_id = permission.id WHERE permission.customer = 1 ORDER BY id DESC LIMIT ?, ?", [0, 5]);

    $app->render('admin/home.php', [
        'orders' => $orders->results(),
        'customers' => $customers
    ]);

})->name('admin_home');


$app->get('/admin/sales', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    if ($request->isAjax()) {

        $results = $app->db->custom("SELECT month(created_at) as month, year(created_at) as year, SUM(total) AS month_total FROM `order` WHERE status = ? GROUP BY month ORDER BY month", ['shipped']);

        $month = 1;
        $sales = [];
        $year = date('Y');

        while ($month <= 12) {

            $has = false;

            foreach ($results as $row) {
                if ($row['month'] == $month && $row['year'] == $year) {
                    $sales[] = $row['month_total'];
                    $has = true;
                }
            }

            if ($has == false) {
               $sales[] = 0;
            }

            $month++;
        }

        echo json_encode($sales);
        exit();

    } else {
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('admin_home_sales');