<?php

use Pos\Helpers\Validator\Forms\AddressForm;
use Pos\Helpers\Validator\Forms\ResetForm;
use Pos\Helpers\Validator\Forms\CustomerForm;

$app->get('/settings/address/new', $auth(true), $customer(), function() use ($app) {
    $request = $app->request;  

    $app->render('settings/address_new.php', [
        'return_url' => ($request->get('return') != "") ? $request->get('return') : ""
    ]);
    
})->name('settings.address_new');

$app->post('/settings/address/new', $auth(true), $customer(), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;

    $v = $app->validator->validate(AddressForm::rules(), AddressForm::lables());

    if($v->validate()) {

        $app->db->insert('address', [
            'address1' => $request->post('address1'),
            'address2' => $request->post('address2'),
            'city' => $request->post('city'),
            'postal_code' => $request->post('postal_code'),
            'telephone' => $request->post('telephone'),
            'customer_id' => $app->customer['id']
        ]);

        if($request->get('return') == "order") {
            $app->response->redirect($app->urlFor('order'));
        } else {
            $app->flash('success', 'Address created successful');
            $app->response->redirect($app->urlFor('home'));
        }

    } else {
        $errors = $v->errors();
    }

    $app->render('settings/address_new.php', [
        'request' => $request,
        'errors' => $errors,
        'return_url' => ($request->get('return') != "") ? $request->get('return') : ""
    ]);
    
});

$app->get('/settings/address/edit/:id', $auth(true), $customer(), function($id) use ($app) {

    $address = $app->db->get('address', 'id=?', [$id])->first();

    if($address && $address->customer_id == $app->customer['id']){
        $app->render('settings/address_edit.php', [
            'address' => $address
        ]);
    } else {
        $app->flash('error', 'Address id is invaid');
        $app->response->redirect($app->urlFor('order'));
    }
    
})->name('settings.address_edit');

$app->post('/settings/address/edit/:id', $auth(true), $customer(), function($id) use ($app) {

    $address = $app->db->get('address', 'id=?', [$id])->first();

    if($address && $address->customer_id == $app->customer['id']){

        $request = $app->request;

        // all errors
        $errors = null;

        $v = $app->validator->validate(AddressForm::rules(), AddressForm::lables());

        if($v->validate()) {

            $app->db->update('address', $address->id, [
                'address1' => $request->post('address1'),
                'address2' => $request->post('address2'),
                'city' => $request->post('city'),
                'postal_code' => $request->post('postal_code'),
                'telephone' => $request->post('telephone'),
                'customer_id' => $app->customer['id']
            ]);

            $app->flash('success', 'Address updated successful');
            $app->response->redirect($app->urlFor('settings.address_edit', ['id' => $address->id]));

        } else {
            $errors = $v->errors();
        }

        $app->render('settings/address_edit.php', [
            'address' => $address,
            'request' => $request,
            'errors' => $errors,
        ]);


    } else {
        $app->flash('error', 'Address id is invaid');
        $app->response->redirect($app->urlFor('order'));
    }
    
});

$app->get('/settings/address/all', $auth(true), $customer(), function() use ($app) {

    $addresses = $app->db->getAll('address', 'customer_id=?', [$app->customer['id']])->results();

    $app->render('settings/address_all.php', [
            'addresses' => $addresses
    ]);
    
})->name('settings.address_all');

// END ADDRESS

$app->get('/settings/change/password', $auth(true), function() use ($app) {

    $app->render('settings/change_password.php', [
        'return' => ($app->request->get('return') == "admin") ? true : false
    ]);
    
})->name('settings.change_password');

$app->post('/settings/change/password', $auth(true), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;

    $v = $app->validator->validate(ResetForm::rules(), ResetForm::lables());

    if($v->validate()) {

        if ($app->hash->passwordCheck($request->post('current_password'), $app->auth->password)) {
            
            $app->db->update('user', $app->auth->id, [
                'password' => $app->hash->passwordHash($request->post('password'))
            ]);

            $app->flash('success', 'Password updated successful');
            $app->response->redirect($app->urlFor('settings.change_password'));

        } else {
            $app->flash('error', 'Current Password is invaid');
            $app->response->redirect($app->urlFor('settings.change_password'));
        }

    } else {
        $errors = $v->errors();
    }

    $app->render('settings/change_password.php', [
        'errors' =>  $errors,
        'return' => ($app->request->get('return') == "admin") ? true : false
    ]);
    
});

$app->get('/settings/change/info', $auth(true), function() use ($app) {

    $app->render('settings/change_info.php', [
        'user' => $app->auth,
        'info' => ($app->permission['admin'] || $app->permission['staff']) ? $app->staff : $app->customer,
        'return' => ($app->request->get('return') == "admin") ? true : false
    ]);
    
})->name('settings.change_info');

$app->post('/settings/change/info', $auth(true), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;

    $v = $app->validator->validate(CustomerForm::rules($app->auth->email), CustomerForm::lables());

    if($v->validate()) {

        if ($app->hash->passwordCheck($request->post('current_password'), $app->auth->password)) {
            
            $app->db->update('user', $app->auth->id, [
                'email' => $request->post('email')
            ]);

            $app->db->update('customer', $app->customer['id'], [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
            ]);

            $app->flash('success', 'Your inforamtion updated successful');
            $app->response->redirect($app->urlFor('settings.change_info'));

        } else {
            $app->flash('error', 'Current Password is invaid');
            $app->response->redirect($app->urlFor('settings.change_info'));
        }

    } else {
        $errors = $v->errors();
    }

    $app->render('settings/change_info.php', [
        'user' => $app->auth,
        'info' => ($app->permission['admin'] || $app->permission['staff']) ? $app->staff : $app->customer,
        'errors' =>  $errors,
        'return' => ($app->request->get('return') == "admin") ? true : false
    ]);
    
});
