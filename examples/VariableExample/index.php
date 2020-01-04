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
require 'UserProfile.php';

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//var' => 'Pxp\DynamicElement\Variable',
        '//widget' => 'Pxp\DynamicElement\Widgets\{name}',
    ],
    'hooks' => [
        'onRender' => 'RETURN_CALL',
    ]
];

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
