<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This example demonstrates Modules passing arguments
 */

require '../../vendor/autoload.php';
require 'Head.php';
require 'Footer.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();


// define build config
$config = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'modules' => [
        'types' => [
            [
                'name' => 'Header',
                'class_name' => 'LivingMarkup\Modules\Header',
                'xpath' => '//header',
            ],
            [
                'name' => 'Footer',
                'class_name' => 'LivingMarkup\Modules\Footer',
                'xpath' => '//footer',
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

echo $director->build($builder, $config);
