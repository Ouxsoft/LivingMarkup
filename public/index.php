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

$router = new LivingMarkup\Router();
$router->response();