<?php

require_once '../vendor/autoload.php';

use Laminas\Validator\File\Exists;

// define common directories
define('ROOT_DIR', dirname(__DIR__, 1) . '/');
define('PUBLIC_DIR', ROOT_DIR . 'public/');
define('ASSET_DIR', ROOT_DIR . 'assets/');
define('IMAGE_DIR', ASSET_DIR . 'images/');

// set include path
set_include_path( ROOT_DIR);

// ensures that notices can be caught by tests
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Router
$route = (array_key_exists('REDIRECT_URL', $_SERVER))?$_SERVER['REDIRECT_URL']:'';
$route = (string) ltrim($route, '/');

$validator = new Exists(PUBLIC_DIR);

// TROUBLESHOOT? Hint, files need a root element
try {
    if($route==''){
        require 'home.php';
    } else if ( is_file($route)) {
        require $route;
    } else {
        require '404.php';
    }
} catch (Exception $e) {
    require '404.php';
}