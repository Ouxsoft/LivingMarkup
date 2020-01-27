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
 * This example demonstrates how easy is it is to spoof an existing web page using PHP.
 */

require '../../vendor/autoload.php';
require 'MarkupInjection.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    // 'filename' => 'http://example.com',
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',

    'handlers' => [
        '//h1'           => 'LivingMarkup\Component\MarkupInjection',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);
