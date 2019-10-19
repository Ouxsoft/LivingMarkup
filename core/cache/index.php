<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// this script is being called because the file was not detected.
// make the file
// then send it
// as for cache clearing
// that's another process

$parameters = Pxp\Path::decode($_GET['q']);

// query id for path
// $bind->value('id', $parameters['id']);

$source = __DIR__ . '/../../site/assets/images/pxp/logo/original.jpg';

// resize based on parameters

// save file

// TODO: inject rewrite checking
header('Content-Type: image/jpeg');
readfile($source);
