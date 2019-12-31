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
 * This is a "Hello, World" example
 */

require '../../vendor/autoload.php';
require 'HelloWorld.php';

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//widget'         => 'Pxp\DynamicElement\Widgets\{name}',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
