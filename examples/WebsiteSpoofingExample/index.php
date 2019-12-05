<?php
/**
 * This example demonstrates how easy is it is to spoof an existing web page using PHP.
 */

require '../../vendor/autoload.php';

class MarkupInjection extends \Pxp\DynamicElement\DynamicElement
{
    public function onRender()
    {
        return '<h1 style="color:#F00">Spoofed :-)</h1>';
    }
}

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => 'http://example.com',
    'handlers' => [
        '//h1'           => 'MarkupInjection',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);