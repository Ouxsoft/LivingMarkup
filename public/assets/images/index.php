<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Laminas\Validator\File\Exists;
use LivingMarkup\ImageResize;

/*
 work in progress
 checks if an image exists in cache
 if it does not it checks to see if the image exists in assets
 if the image does than it generates a resized image and stores it in cache
 and then serves that image
*/

$filename = 'logo/original.jpg';

// declare directories
$root_dir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR;

$assets_dir = $root_dir . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
$assets_filepath = $assets_dir . $filename;
$assets_validator = new Exists($assets_dir);

$cache_dir = $root_dir . 'var' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
$cache_filepath = $cache_dir . $filename;
$cache_validator = new Exists($cache_dir);

// Set a maximum height and width
$width = 200;
$height = 200;

/*

// if cache provide
if ($cache_validator->isValid($filename)) {
    // return cached image
    header('Content-Type: image/jpeg');
    echo file_get_contents($cache_filepath, false);
    die();
}
*/

// if asset cache and provide
//if ($assets_validator->isValid($filename)) {

    // get width and height
    list($width_original, $height_original) = getimagesize($assets_filepath);

    // determine original ratio
    $ratio_original = $width_original / $height_original;

    if ($width / $height > $ratio_original) {
        $width = $height * $ratio_original;
    } else {
        $height = $width / $ratio_original;
    }

    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($assets_filepath);
    imagecopyresampled($image_p,
        $image,
        0,
        0,
        0,
        0,
        $width,
        $height,
        $width_original,
        $height_original);

    // output
//header('Content-Type: image/jpeg');
var_export($image_p);
//imagejpeg($image_p, null, 100);

    /*
} else {
    echo 'no file found' . $assets_filepath . ' ' . $filename;
}*/