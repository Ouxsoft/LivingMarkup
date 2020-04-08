<?php
// turn off LHTML5 Autoloader
define('LHTML_OFF', 0);

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use LivingMarkup\Image;
use LivingMarkup\Path;

$request = array_key_exists('q', $_GET) ? 'assets/images/' . $_GET['q'] : '';
$parameters = Path::Decode($request);

$filename = substr($parameters['filename'], strlen('/assets/images/'));

$image = new Image($filename);

// set height
if(array_key_exists('height', $parameters)) {
    $image->setHeight($parameters['height']);
}

// set width
if(array_key_exists('width', $parameters)){
    $image->setWidth($parameters['width']);
}

// set offset x
if(array_key_exists('offset_x', $parameters)){
    $image->setFocalPointX($parameters['offset_x']);
}

// set offset y
if(array_key_exists('offset_y', $parameters)){
    $image->setFocalPointX($parameters['offset_y']);
}

$image->output();