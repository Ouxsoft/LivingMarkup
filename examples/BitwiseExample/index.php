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


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require 'Bitwise.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate PageBuilder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();


// define build config
$config = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'modules' => [
        'types' => [
            [
                'name' => 'Bitwise',
                'class_name' => 'LivingMarkup\Modules\Bitwise',
                'xpath' => '//bitwise',
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
