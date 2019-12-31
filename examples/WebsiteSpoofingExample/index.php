<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Pxp\DynamicElement\DynamicElement;

/**
 * This example demonstrates how easy is it is to spoof an existing web page using PHP.
 */

require '../../vendor/autoload.php';
require 'MarkupInjection.php';

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => 'http://example.com',
    'handlers' => [
        '//h1'           => 'Pxp\DynamicElement\MarkupInjection',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
