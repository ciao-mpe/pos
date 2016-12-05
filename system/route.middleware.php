<?php

/*
Auth middleware
*/
$auth = function($required) use ($app) {
    return function() use($required, $app) {
        //if redirect to login the user is not loggedin
        if( (!$app->auth && $required)) {
            $app->flash('error', 'Login required');
            $app->redirect($app->urlFor('login'));
        }
        //if redirect to home the user is already loggedin
        if($app->auth && !$required) {
            $app->redirect($app->urlFor('home'));
        }
    };
};

$customer = function() use ($app) {
    return function() use($app) {
        if($app->auth) {
            if (!$app->permission['customer']) {
                $app->flash('error', 'Your not a customer, customer has permission to access this page');
                $app->redirect($app->urlFor('home'));
            }
        }
    };
};


$admin = function() use ($app) {
    return function() use($app) {
        if($app->auth) {
            if (!$app->permission['admin']) {
                $app->flash('error', 'Permission Denied');
                if ($app->permission['staff']) {
                   $app->redirect($app->urlFor('admin_home'));
                } else{
                    $app->redirect($app->urlFor('home'));
                }
            }
        }
    };
};

$admin_staff = function() use ($app) {
    return function() use($app) {
        if($app->auth) {
            if (!$app->permission['admin'] && !$app->permission['staff']) {
                $app->flash('error', 'Permission Denied');
                $app->redirect($app->urlFor('home'));
            }
        }
    };
};

