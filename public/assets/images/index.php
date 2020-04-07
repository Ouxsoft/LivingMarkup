<?php
// turn off LHTML5 Autoloader
define('LHTML_OFF', 0);

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use LivingMarkup\ImageResize;

$image = new ImageResize('logo/original.jpg');
$image->setDimensions(300,300);
$image->output();