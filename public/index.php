<?php

require_once '../vendor/autoload.php';

// ensures that notices can be caught by tests
// TROUBLESHOOT? Hint, files need a root element
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// define common directories
define('ROOT_DIR', dirname(__DIR__, 1) . '/');
define('PUBLIC_DIR', ROOT_DIR . 'public/');
define('ASSET_DIR', ROOT_DIR . 'assets/');
define('IMAGE_DIR', ASSET_DIR . 'images/');

// set include path
set_include_path( ROOT_DIR);

// Router
$route = (array_key_exists('REDIRECT_URL', $_SERVER))?$_SERVER['REDIRECT_URL']:'';
$route = (string) ltrim($route, '/');

// send empty request to home
if($route==''){ $route = 'home';}

// check for file as php file if a extension not provided in request
$route .= (pathinfo($route)['extension']=='')?'.php':'';

// check for directory traversal or if file does not exist
$real_base = realpath(PUBLIC_DIR);
$user_path = PUBLIC_DIR . $route;
$real_user_path = realpath($user_path);
if (($real_user_path === false) || (strpos($real_user_path, $real_base) !== 0) || (is_file($route) == false)) {
    // return 404 page
    $route = '404.php';
}

require $route;