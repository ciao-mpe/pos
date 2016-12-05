<?php

use Pos\Helpers\Validator\Forms\SupplierForm;

$app->get('/admin/supplier/add', $auth(true), $admin_staff(), function() use ($app) {

    $app->render('admin/supplier/add.php');

})->name('supplier_add');

$app->post('/admin/supplier/add', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;

    $v = $app->validator->validate(SupplierForm::rules(), SupplierForm::lables());

    if ($v->validate()) {

        $app->db->insert('supplier', [
            'company_name' => $request->post('company_name'),
            'email' => $request->post('email'),
            'address' => $request->post('address'),
            'telephone' => $request->post('telephone'),
        ]);

        //flashing message and redirecting to the home
        $app->flash('success', 'Supplier addedd successful');
        $app->response->redirect($app->urlFor('admin_home'));

    } else {
        $errors = $v->errors();
    }

    $app->render('admin/supplier/add.php', [
        'errors' => $errors,
        'request' => $request
    ]);

});

$app->get('/admin/supplier/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $supplier = $app->db->get('supplier', 'id=?', [$id])->first();

    if ($supplier) {
        
        $app->render('admin/supplier/edit.php', [
            'supplier' => $supplier
        ]);

    } else {
        $app->flash('error', 'Supplier id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('supplier_edit');

$app->post('/admin/supplier/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $supplier = $app->db->get('supplier', 'id=?', [$id])->first();

    if ($supplier) {

        $request = $app->request;

        // all errors
        $errors = null;

        $v = $app->validator->validate(SupplierForm::rules($supplier->email, $supplier->telephone), SupplierForm::lables());

        if ($v->validate()) {

            $app->db->update('supplier', $supplier->id,[
                'company_name' => $request->post('company_name'),
                'email' => $request->post('email'),
                'address' => $request->post('address'),
                'telephone' => $request->post('telephone'),
            ]);

            $app->flash('success', 'Supplier updated successful');
            $app->response->redirect($app->urlFor('supplier_edit', ['id' => $supplier->id]));

        }else {
            $errors = $v->errors();
        }
        
        $app->render('admin/supplier/edit.php', [
            'supplier' => $supplier,
            'request' => $request,
            'errors' => $errors,
        ]);

    } else {
        $app->flash('error', 'Supplier id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

});

$app->get('/admin/supplier/all', $auth(true), $admin_staff(), function() use ($app) {

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
            $query = "email=?";
            $bindings = [$search_email];
        } else {
            $query = "ORDER BY id DESC LIMIT ".$start.", ".$length;
        }

        $supplier = $app->db->getAll('supplier', $query, $bindings);

        echo json_encode([
            "recordsTotal" => $supplier->count(),
            "recordsFiltered" => $supplier->count(),
            'data' => $supplier->toArray(),
        ]);
        exit();

    }

    $app->render('admin/supplier/all.php');

})->name('supplier_all');

$app->get('/admin/supplier/delete/:id', $auth(true), $admin(), function($id) use ($app) {

    $supplier = $app->db->get('supplier', 'id=?', [$id])->first();

    if ($supplier) {
        
       $app->db->delete('supplier', $supplier->id);

       $app->flash('success', 'Supplier deleted successful');
       $app->response->redirect($app->urlFor('supplier_all'));

    } else {
        $app->flash('error', 'Supplier id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('supplier_delete');