<?php

//Reset Form Validation Helper
use Pos\Helpers\Validator\Forms\ResetForm;

$app->get('/login', $auth(false), function() use ($app) {

    $app->render('login.php');

})->name('login');


$app->post('/login', $auth(false), function() use ($app) {

    $request = $app->request;

    $user = $app->db->get('user', 'email = ?', [$request->post('email')])->first();

    if($user) {

        if ($app->hash->passwordCheck($request->post('password'), $user->password) && $user->ownPermission[0]['banned'] == 0) {

            if($user->ownPermission[0]['admin'] || $user->ownPermission[0]['staff']) {
                
                $_SESSION['auth'] = $user->id;
                $app->flash('success', 'Login Successful');
                $app->response->redirect($app->urlFor('admin_home'));

            } else {
                $_SESSION['auth'] = $user->id;
                $app->flash('success', 'Login Successful');
                $app->response->redirect($app->urlFor('home'));
            }

        } else {
            $app->flash('error', 'Authentication faild or your account is banned, please contact our cutomer care');
            $app->response->redirect($app->urlFor('login'));
        }

    } else {
        $app->flash('error', 'Authentication Faild');
        $app->response->redirect($app->urlFor('login'));
    }

});

$app->get('/auth/logout', $auth(true), function() use ($app) {

    $app->basket->clear();
    $app->pocart->clear();

    unset( $_SESSION['auth'] );

    $app->response->redirect($app->urlFor('login'));

})->name('logout');

$app->get('/forget', $auth(false), function() use ($app) {

    $app->render('forget.php');

})->name('forget');

$app->post('/forget', $auth(false), function() use ($app) {

    $request = $app->request;

    $user = $app->db->get('user', 'email = ?', [$request->post('email')])->first();

    if($user) {

        $app->db->deleteAll('reset', 'user_id = ?', [$user->id]);
        
        $reset_token = $app->hash->hash(md5(time()));

        $reset = $app->db->insert('reset', [
            'token' => $reset_token,
            'user_id' => $user->id
        ]);

        $reset_url = $app->config->get('app.url').$app->urlFor('reset', ['token' => $reset_token]);

        $app->mail->setTo($user->email, '')
         ->setSubject('Rest Passowrd Token')
         ->setFrom('no-reply@lucids.info', 'lucids.info')
         ->addMailHeader('Reply-To', 'no-reply@lucids.info', 'lucids.info')
         ->addMailHeader('Cc', '', '')
         ->addMailHeader('Bcc', '', '')
         ->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
         ->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
         ->setMessage('<p>Reset your password by <a href="'.$reset_url.'">Click Here</a> </p>')
         ->setWrap(500);
        $send =  $app->mail->send();

        if($send) {
            $app->flash('success', 'Reset Password link sent to your email');
            $app->response->redirect($app->urlFor('login'));
        } else {
            $app->flash('error', 'Mail Sent Faild');
            $app->response->redirect($app->urlFor('forget'));
        }

    } else {
        $app->flash('error', 'Email is invalid');
        $app->response->redirect($app->urlFor('forget'));
    }

    $app->render('forget.php');

});

$app->get('/reset/:token', $auth(false), function($token) use ($app) {

    $token = $app->db->get('reset', 'token = ?', [$token])->first();

    if ($token) {
        $app->render('reset.php', [
            'token' => $token->token
        ]);
    } else {
        $app->flash('error', 'Reset Token is Invalid');
        $app->response->redirect($app->urlFor('login'));
    }

})->name('reset');

$app->post('/reset/:token', $auth(false), function($token) use ($app) {

    $request = $app->request;

    $token = $app->db->get('reset', 'token = ?', [$token])->first();

    if ($token) {
       
        // all errors
        $errors = null;

        $v = $app->validator->validate(ResetForm::rules(), ResetForm::lables());

        if($v->validate()) {

            $app->db->update('user', $token->user_id, [
                'password' => $app->hash->passwordHash($request->post('password'))
            ]);

            $app->db->delete('reset', $token->id);

            $app->flash('success', 'Password Reset Successful');
            $app->response->redirect($app->urlFor('login'));

        } else {
            $errors = $v->errors();
        }

        $app->render('reset.php', [
            'token' => $token->token,
            'errors' => $errors
        ]);
    
    } else {
        $app->flash('error', 'Reset Token is Invalid');
        $app->response->redirect($app->urlFor('login'));
    }

});
