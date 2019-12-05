<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'page.html',
    'handlers' => [
        '//partial'     => 'Pxp\DynamicElement\Partials\{name}',
        '//widget'      => 'Pxp\DynamicElement\Widgets\{name}',
        '//head'        => 'Pxp\DynamicElement\Head',
        '//img'         => 'Pxp\DynamicElement\Img',
        '//a'           => 'Pxp\DynamicElement\A',
        '//footer'      => 'Pxp\DynamicElement\Footer',
        '//var'         => 'Pxp\DynamicElement\Variable',
        '//condition'   => 'Pxp\DynamicElement\Condition',
        '//redacted'    => 'Pxp\DynamicElement\Redacted'
    ],
    'hooks' => [
        'beforeLoad'    => 'Executed before onLoad',
        'onLoad'        => 'Loads object data',
        'afterLoad'     => 'Executed after onLoad',
        'beforeRender'  => 'Executed before onLoad',
        'onRender'      => 'RETURN_CALL',
        'afterRender'   => 'Executed after onRender',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
