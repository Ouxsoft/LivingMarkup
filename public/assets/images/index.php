<?php
// turn off LHTML5 Autoloader
define('LHTML_OFF', 0);

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use LivingMarkup\Image;
use LivingMarkup\Path;

$request = array_key_exists('q', $_GET) ? 'assets/images/' . $_GET['q'] : '';
$image = new Image();
$image->loadByURL($request);
$image->output();