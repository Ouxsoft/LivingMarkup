<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL );  //& E_DEPRECATED

require_once __DIR__ . '/vendor/autoload.php';

// Declare a new PXP Document Object Model (DOM)
$pxp_doc = new Pxp\Document();

// Load an HTML/XML Document
$pxp_doc->loadByPath('site/pages/index.php');

$pxp_processor = new Pxp\Processor();


/*

Tag Handlers

A tag handler consists of a key (XPath expression) and a value (Class).
The XPath expression is used to find elements and the Class specifies how to instantiate that element once found.
The same tag may be instatiated using different classes provided the element's name attribute is in the class (e.g. '\Templates\{name}').
*/

// TODO: Should these be added or detected??
$pxp_doc->tagHandlersAdd([
    '//partial' => 'Partials\{name}',
    '//widget' => 'Widgets\{name}',
    '//head' => 'Elements\Head',
    '//img' => 'Elements\Img',
    '//a' => 'Elements\A',
    '//footer' => 'Elements\Footer',
    '//var' => 'Logic\Variable',
    '//condition' => 'Logic\Condition',
]);

/*

Tag Hooks

Define initial list of methods calls made sequentially to dyanmic element objects.
To orchestrate the method execution addition hooks may be defined within Tag Handlers. 
For a complete at runtime list, use $pxp_doc->tagHooksList();

*/

$pxp_processor->tagHooksAdd([
    'beforeLoad' => 'Executed before load',
    'onLoad' => 'Executed on load',
    'afterLoad' => 'Executed after load',
    'beforeReturn' => 'Executed before return',
    'onReturn' => 'Executed on return',
    'afterReturn' => 'Execute after return'
]);

// Deliver HTML Document
echo $pxp_doc;
