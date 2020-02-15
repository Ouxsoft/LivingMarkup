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
 * This example shows how conditional statements can be made using LivingMarkup
 */

require '../../vendor/autoload.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate PageBuilder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define a datetime to allow consistent display results
// comment out to default to NOW
define('LivingMarkup_DATETIME', '2019-12-03 01:30:00');

// define build config
$config = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'modules' => [
        'types' => [
            [
                'name' => 'If Statement',
                'class_name' => 'LivingMarkup\Modules\IfStatement',
                'xpath' => '//if'
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
