<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This example demonstrates Components passing arguments
 */

require '../../vendor/autoload.php';
require 'Head.php';
require 'Footer.php';

// instantiate Director
$director = new Pxp\Director();

// instantiate Builder
$builder = new Pxp\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//head' => 'Pxp\Component\Head',
        '//footer' => 'Pxp\Component\Footer',
    ],
    'hooks' => [
        'onRender' => 'RETURN_CALL',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);