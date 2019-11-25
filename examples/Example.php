<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  //& E_DEPRECATED

require_once __DIR__ . '/vendor/autoload.php';

// create Director 
$director = new Pxp\Director();

// create PageBuilder
$page_builder = new Pxp\PageBuilder();

// specify build parameters
$parameters = [
    'filename' => 'site/pages/index.php',
    'handlers' => [
        '//partial' => 'Partials\{name}',
        '//widget' => 'Widgets\{name}',
        '//head' => 'Elements\Head',
        '//img' => 'Elements\Img',
        '//a' => 'Elements\A',
        '//footer' => 'Elements\Footer',
        '//var' => 'Logic\Variable',
        '//condition' => 'Logic\Condition',
        '//redacted' => 'Logic\Redacted'
    ],
    'hooks' => [
        'beforeLoad' => 'Executed before onLoad',
        'onLoad' => 'Loads object data',
        'afterLoad' => 'Executed after onLoad',
        'beforeRender' => 'Executed before onLoad',
        'onRender' => 'RETURN_CALL',
        'afterRender' => 'Executed after onRender',        
    ]
];

// output
echo $director->build($page_builder, $parameters);