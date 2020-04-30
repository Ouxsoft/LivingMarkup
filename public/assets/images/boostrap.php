<?php
// turn off LHTML5 Autoloader
define('LHTML_OFF', 0);

require 'vendor/autoload.php';

echo 'dd';
die();
/*
use LivingMarkup\Image;
use LivingMarkup\Path;

$request = array_key_exists('q', $_GET) ? 'assets/images/' . $_GET['q'] : '';
$image = new Image();
$image->loadByURL($request);
$image->output();*/