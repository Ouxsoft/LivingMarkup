<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use LivingMarkup\Modules\Module;

/**
 * This example demonstrates how easy is it is to spoof an existing web page using PHP.
 */

require '../../vendor/autoload.php';
require 'MarkupInjection.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define build config
$config = [
    // filename => 'https://example.com',
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'modules' => [
        'types' => [
            [
                'name' => 'Markup Injection',
                'class_name' => 'LivingMarkup\Modules\MarkupInjection',
                'xpath' => '//h1',
            ]
        ],
        'methods' => [
            [
                'name' => 'onRender',
                'description' => 'Execute while object is rendering',
                'execute' => 'RETURN_CALL',
            ]
        ]
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $config);
