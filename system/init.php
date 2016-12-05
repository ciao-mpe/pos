<?php
/*
Import Slim Libs
*/
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/*
Import configuration lib
*/
use Noodlehaus\Config;

/*
Import Helpers to the application
 */
use Pos\Helpers\Database;
use Pos\Helpers\Email;
use Pos\Helpers\Hash;
//validation helper
use Pos\Helpers\Validator\Validator;

//shoping cart helper
use Pos\Helpers\Cart\Storage;
use Pos\Helpers\Cart\Basket;

//po cart helper
use Pos\Helpers\PurchaseOrder\Basket AS PoBasket;

/*
Import application Middlewares
*/
use Pos\Middlewares\BeforeMiddleware;
use Pos\Middlewares\CsrfMiddleware;

/*
Import Valitron Validator
*/
use Valitron\Validator as ValitronValidator;

/*
App Sesssions
*/
session_start();

/*
Display errors turn on
*/
ini_set('display_errors', 'On');

/**
Constant for direct app path
*/
defined('APP_PATH') || define('APP_PATH', dirname(__DIR__));

/*
Load all vendors
*/
require APP_PATH.'/vendor/autoload.php';

/*
Slim Application Instance and create twig instance for the slim view
*/
$app = new Slim([
    'debug' => true,
    'view' => new Twig(),
    'templates.path' => APP_PATH.'/system/templates',
]);

/*
Set app configurations to the slim app using hassankhan configuration lib
*/
$app->config = Config::load(APP_PATH.'/system/config/config.php');

/*
Configurataion Slim view with twig
*/
$view = $app->view();
$view->parserOptions = [
    'debug' => $app->config->get('twig.debug')
];
$view->parserExtensions = [
    new TwigExtension,
    new Twig_Extension_Debug()
];

/*
Set Default timezone to php
 */
date_default_timezone_set($app->config->get('app.timezone'));

/*
Set auth and permission variable to false
*/
$app->auth = false;
$app->permission = false;
$app->customer = false;
$app->staff = false;

/*
Add Database Helper to the application
*/
$app->container->singleton('db', function() use ($app) {
    return new Database($app->config);
});

/*
Add Email Helper to the application
*/
$app->container->singleton('mail', function() use ($app) {
    return new Email;
});

/*
Add hash Helper to the application
*/
$app->container->singleton('hash', function() use ($app) {
    return new Hash($app->config, $app->container->get('db'));
});

/*
Add Valitron Validator Lib to the application
*/
$app->container->singleton('valitronv', function() use ($app) {
    return new ValitronValidator($_POST);
});

/*
Add validate Helper to the application
*/
$app->container->singleton('validator', function() use ($app) {
   return new Validator($app->container->get('valitronv'), $app->container->get('db'));
});

/*
Add Shopping Cart Helpers to the application
*/
$app->container->singleton('storage', function() use ($app) {
    return new Storage('cart');
});

$app->container->singleton('basket', function() use ($app) {
    return new Basket($app->container->get('storage'), $app->container->get('db'));
});

/*
Add Po Cart Helper to the application
 */
$app->container->singleton('postorage', function() use ($app) {
    return new Storage('pocart');
});
$app->container->singleton('pocart', function() use ($app) {
    return new PoBasket($app->container->get('postorage'), $app->container->get('db'));
});


$twig = $app->view->getEnvironment();
// Twig Global Classes
$twig->addGlobal('basket', $app->container->get('basket'));
$twig->addGlobal('pocart', $app->container->get('pocart'));

/*
Add Middlewares to the application
*/
$app->add(new BeforeMiddleware($app->container->get('db')));
$app->add(new CsrfMiddleware);

/*
Load Static Functions
*/
require APP_PATH.'/system/functions.php';

/*
Load route middelwares
*/
require APP_PATH.'/system/route.middleware.php';

/*
Load all pages 
*/
require APP_PATH.'/system/pages/pages.php';