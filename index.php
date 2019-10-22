<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL );  //& E_DEPRECATED

require_once __DIR__ . '/vendor/autoload.php';

$pxp_processor = new Pxp\Processor();
$pxp_processor->handlersAdd([
    '//partial' => 'Partials\{name}',
    '//widget' => 'Widgets\{name}',
    '//head' => 'Elements\Head',
    '//img' => 'Elements\Img',
    '//a' => 'Elements\A',
    '//footer' => 'Elements\Footer',
    '//var' => 'Logic\Variable',
    '//condition' => 'Logic\Condition',
]);
$pxp_processor->hooksAdd([
    'beforeLoad' => 'Executed before load',
    'onLoad' => 'Executed on load',
    'afterLoad' => 'Executed after load',
    'beforeReturn' => 'Executed before return',
    'onReturn' => 'Executed on return',
    'afterReturn' => 'Execute after return'
]);

// Load an HTML/XML PXP Document Object Model (DOM)
$pxp_doc = new Pxp\Document();
$pxp_doc->loadByPath('site/pages/index.php');

$pxp_processor->process($pxp_doc);

// Deliver HTML Document
echo $pxp_doc;