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

require '../../vendor/autoload.php';
require 'UserProfile.php';
require 'GroupProfile.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define build config
$config = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'components' => [
        'types' => [
            [
                'name' => 'Widget',
                'class_name' => 'LivingMarkup\Component\Widgets\{name}',
                'xpath' => '//widget',
            ],
            [
                'name' => 'Variable',
                'xpath' => '//var',
                'class_name' => 'LivingMarkup\Component\Variable',
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
