<?php

/*
    All configuration data goes here
    1.app configurations
    2.hash configuration algo
    2.database configurations
*/

return [
    'app' => [
        'url' => 'http://localhost:8080/pos/',
        'css' => '/public/assets/css',
        'js' => '/public/assets/js',
        'images' => '/public/assets/images',
        'timezone' => 'Asia/Colombo',
    ],
    'hash' => [
        'algo' => PASSWORD_BCRYPT,
        'cost' => 10
    ],
    'db' => [
        'host' => 'localhost',
        'database' => '',
        'username' => '',
        'password' => '',
        'type' => 'sqlite', //mysql or sqlite
        'file' =>  APP_PATH.'/system/storage/zeus.sqlite' //sqllite database file path
    ],
    'twig' => [
        'debug' => true
    ]
];