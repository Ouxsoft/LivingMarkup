<?php

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


// TODO: Security issue


if( ! array_key_exists('REDIRECT_URL', $_SERVER) || $_SERVER["REDIRECT_URL"] == '') {
    require 'home.lhtml';
    die();
}

$request = PUBLIC_DIR . $_SERVER["REDIRECT_URL"];
if (file_exists($request)){
    require $request;
} else {
    echo 'Page not found.';
}
