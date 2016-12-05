<?php

use Pos\Helpers\Validator\Forms\StaffForm;

$app->get('/admin/staff/add', $auth(true), $admin(), function() use ($app) {

    $app->render('admin/staff/add.php');

})->name('staff_add');

$app->post('/admin/staff/add', $auth(true), $admin(), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;

    $v = $app->validator->validate(StaffForm::rules(), StaffForm::lables());

    if ($v->validate()) {

        //create user
        $user = $app->db->insert('user', [
            'email' => $request->post('email'),
            'password' => $app->hash->passwordHash($request->post('password')),
        ]);
        $user_id = $user->lastInsertid();

        //create user permission
        $app->db->insert('permission', [
            'staff' => 1,
            'user_id' => $user_id
        ]);

        //create staff
        $staff = $app->db->insert('staff', [
            'first_name' => $request->post('first_name'),
            'last_name' => $request->post('last_name'),
            'user_id' => $user_id
        ]);

        //flashing message and redirecting tot the home
        $app->flash('success', 'Staff member addedd successful');
        $app->response->redirect($app->urlFor('admin_home'));
       
    } else {
        $errors = $v->errors();
    }

    $app->render('admin/staff/add.php', [
        'errors' => $errors,
        'request' => $request
    ]);
});


$app->get('/admin/staff/edit/:id', $auth(true), $admin(), function($id) use ($app) {

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['staff']) {

        $app->render('admin/staff/edit.php', [
            'user' => $user,
            'permission' => $user->ownPermission[0],
            'staff' => $user->ownStaff[0],
        ]);

    } else {
        $app->flash('error', 'Staff id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('staff_edit');

$app->post('/admin/staff/edit/:id', $auth(true), $admin(), function($id) use ($app) {

    $request = $app->request;

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['staff']) {

        $staff = $user->ownStaff[0];

        // all errors
        $errors = null;

        $v = $app->validator->validate(StaffForm::rules($user->email), StaffForm::lables());

        if ($v->validate()) {

             //update user
            $app->db->update('user', $user->id, [
                'email' => $request->post('email')
            ]);

            //update staff
            $app->db->update('staff', $staff['id'],[
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
            ]);
            
            //flashing message and redirecting tot the home
            $app->flash('success', 'Staff member updated successful');
            $app->response->redirect($app->urlFor('staff_edit', ['id' => $user->id]));
           
        } else {
            $errors = $v->errors();
        }

        $app->render('admin/staff/edit.php', [
            'errors' => $errors,
            'user' => $user,
            'permission' => $user->ownPermission[0],
            'staff' => $staff
        ]);

    }else {
        $app->flash('error', 'Staff id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

});


$app->get('/admin/staff/all', $auth(true), $admin(), function() use ($app) {

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

        $result = $app->db->custom("SELECT staff.id, concat(staff.first_name, ' ' ,staff.last_name) as name, user.email, user.id as uid FROM staff JOIN user ON staff.user_id = user.id JOIN permission ON staff.user_id = permission.id WHERE permission.staff = 1 ".$query, $bindings);

        $count = $app->db->custom("SELECT COUNT(*) as count FROM staff JOIN permission ON staff.user_id = permission.id WHERE permission.staff = 1");

        echo json_encode([
            "recordsTotal" => $count[0]['count'],
            "recordsFiltered" => $count[0]['count'],
            'data' => $result,
        ]);
        exit();

    }

    $app->render('admin/staff/all.php');

})->name('staff_all');

//Banned Staff
$app->get('/admin/staff/ban/:id', $auth(true), $admin(), function($id) use ($app) {
    
    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['staff']) {

        if ($user->ownPermission[0]['banned']) {
            $app->db->update('permission', $user->ownPermission[0]['id'], [
                'banned' => 0
            ]);

            $app->flash('success', 'Staff unbanned success');
            $app->response->redirect($app->urlFor('staff_edit', ['id' => $user->id]));
        }

        if ($user->ownPermission[0]['banned'] == 0) {
            $app->db->update('permission', $user->ownPermission[0]['id'], [
                'banned' => 1
            ]);

            $app->flash('success', 'Staff banned success');
            $app->response->redirect($app->urlFor('staff_edit', ['id' => $user->id]));
        }

    } else {
        $app->flash('error', 'Staff id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('staff_ban');

//Delete Staff Member
$app->get('/admin/staff/delete/:id', $auth(true), $admin(), function($id) use ($app) {

    $user = $app->db->get('user', 'id=?', [$id])->first();

    if ($user && $user->ownPermission[0]['staff']) {

        $permission = $user->ownPermission[0];
        $staff = $user->ownStaff[0];
        
        //delete customer
        $app->db->delete('staff', $staff['id']);
        //delete permission
        $app->db->delete('permission', $permission['id']);
        //delete user
        $app->db->delete('user', $user->id);

    } else {
        $app->flash('error', 'Staff id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('staff_delete');