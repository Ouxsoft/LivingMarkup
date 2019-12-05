<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Class MarkupInjection
 *
 * This class will replace a element on the page to indicate it is not actually the original site
 *
 */
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