<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use LivingMarkup\Component\Component;

/**
 * This is a "Hello, World" example
 */

require '../../vendor/autoload.php';
require 'HelloWorld.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//widget'         => 'LivingMarkup\Component\Widgets\{name}',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);
