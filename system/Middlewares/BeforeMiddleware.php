<?php

namespace Pos\Middlewares;

use Slim\Middleware;
/**
* This middleware is used to get user_id from the session and set user data to the application
*/

class BeforeMiddleware extends Middleware
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function call(){ 
        
        //hooking checkAuth method to the slim.before middleware
        $this->app->hook('slim.before', [$this, 'check'] );

        $this->next->call();
    }

    public function check() {

        //call login check method to the main call method
        $this->auth();

        //call parseData method to the main call method
        $this->parseData([
            'config' => $this->app->config->get('app'),

            'auth' => $this->app->auth,
            'permission' => $this->app->permission,
            'customer' => $this->app->customer,

            'baseUrl' => $this->app->config->get('app.url'),
            'css'=> $this->app->config->get('app.url').$this->app->config->get('app.css'),
            'js'=> $this->app->config->get('app.url').$this->app->config->get('app.js'),
            'images' => $this->app->config->get('app.url').$this->app->config->get('app.images'),
            
            'randomPassowrd' => randomPassword()
        ]);


    }

    private function auth() {
        //checking is set auth admin session
        if (isset($_SESSION['auth'])) {

            $user = $this->db->get('user', 'id=?', [$_SESSION['auth']])->first();

            if (!$user || $user->ownPermission[0]['banned']) {
                unset($_SESSION['auth']);
            }
            
            $this->app->auth = $user;
            $this->app->permission = $user->ownPermission[0];
            if ($this->app->permission['customer']) {
                $this->app->customer = $user->ownCustomer[0];
            } else if($this->app->permission['admin'] || $this->app->permission['staff']) {
                $this->app->staff = $user->ownStaff[0];
            }
            
        }
    }

    public function parseData($data) {
        //parsing data to the slim view
        $this->app->view()->appendData($data);
    }

}