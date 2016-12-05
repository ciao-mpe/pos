<?php

use Pos\Helpers\Validator\Forms\CustomerForm;

//Edit Customer
$app->get('/admin/customer/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['customer']) {

        $app->render('admin/customer/edit.php', [
           'customer' => $user->ownCustomer[0],
           'user' => $user,
           'permission' => $user->ownPermission[0]
        ]);

    } else {
        $app->flash('error', 'Customer id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }
})->name('customer_edit');

$app->post('/admin/customer/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['customer']) {

        $request = $app->request;
        $customer = $user->ownCustomer[0];

        // all errors
        $errors = null;


        $v = $app->validator->validate(CustomerForm::rules($user->email), CustomerForm::lables());

        if($v->validate()) {

            //update user
            $app->db->update('user', $user->id, [
                'email' => $request->post('email')
            ]);

            //update customer
            $app->db->update('customer', $customer['id'],[
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
            ]);

            $app->flash('success', 'Customer updated successful');
            $app->response->redirect($app->urlFor('customer_edit', ['id' => $user->id]));

        } else {
            $errors = $v->errors();
        }

        $app->render('admin/customer/edit.php', [
            'customer' => $customer,
            'user' => $user,
            'permission' => $user->ownPermission[0]
        ]);
        
    } else {
        $app->flash('error', 'Customer id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

});

//All Customer
$app->get('/admin/customers', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    if ($request->isAjax()) {

        $start = 0;
        $length = 10;
        $query = "";
        $search_email = $request->get('columns')[2]['search']['value'];

        $bindings = [];

        if ($request->get('start')) {
            $start = $request->get('start');
        }
        if ($request->get('length')) {
            $length = $request->get('length');
        }

        if($search_email != NULL) {
            $query = "AND email=? ORDER BY id DESC";
            $bindings = [$search_email];
        } else {
            $query = "ORDER BY id DESC LIMIT ".$start.", ".$length;
        }

        $result = $app->db->custom("SELECT customer.id, concat(customer.first_name, ' ' ,customer.last_name) as name, user.email, user.id as uid FROM customer JOIN user ON customer.user_id = user.id JOIN permission ON customer.user_id = permission.id WHERE permission.customer = 1 ".$query, $bindings);

        $count = $app->db->custom("SELECT COUNT(*) as count FROM customer JOIN permission ON customer.user_id = permission.id WHERE permission.customer = 1");

        echo json_encode([
            "recordsTotal" => $count[0]['count'],
            "recordsFiltered" => $count[0]['count'],
            'data' => $result,
        ]);
        exit();
    }

    $app->render('admin/customer/all.php');

})->name('customer_all');

//Banned Customer
$app->get('/admin/customer/ban/:id', $auth(true), $admin_staff(), function($id) use ($app) {
    
    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['customer']) {

        if ($user->ownPermission[0]['banned']) {
            $app->db->update('permission', $user->ownPermission[0]['id'], [
                'banned' => 0
            ]);

            $app->flash('success', 'Customer unbanned success');
            $app->response->redirect($app->urlFor('customer_edit', ['id' => $user->id]));
        }

        if ($user->ownPermission[0]['banned'] == 0) {
            $app->db->update('permission', $user->ownPermission[0]['id'], [
                'banned' => 1
            ]);

            $app->flash('success', 'Customer banned success');
            $app->response->redirect($app->urlFor('customer_edit', ['id' => $user->id]));
        }

    } else {
        $app->flash('error', 'Customer id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('customer_ban');

//Delete Customer
$app->get('/admin/customer/delete/:id', $auth(true), $admin(), function($id) use ($app) {

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['customer']) {

        $customer = $user->ownCustomer[0];
        $permission = $user->ownPermission[0];

        //delete customer addresses
        $app->db->deleteAll('address', 'customer_id = ?', [$customer['id']]);
        //delete customer
        $app->db->delete('customer', $customer['id']);
        //delete permission
        $app->db->delete('permission', $permission['id']);
        //delete user
        $app->db->delete('user', $user->id);

        $app->flash('success', 'Customer deleted successful');
        $app->response->redirect($app->urlFor('customer_all'));

    } else {
        $app->flash('error', 'Customer id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('customer_delete');