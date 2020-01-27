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
 * This example shows how to build a dynamic page using LivingMarkup
 */

require '../../vendor/autoload.php';

// instantiate Director
$director = new LivingMarkup\Director();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//img'         => 'LivingMarkup\Component\Img',
        '//a'           => 'LivingMarkup\Component\A',
        '//widget'      => 'LivingMarkup\Component\Widgets\{name}',
        '//var'         => 'LivingMarkup\Component\Variable',
        '//condition'   => 'LivingMarkup\Component\Condition',
        '//redacted'    => 'LivingMarkup\Component\Redacted'
    ],
    'hooks' => [
        'beforeLoad'    => 'Executed before onLoad',
        'onLoad'        => 'Loads object data',
        'afterLoad'     => 'Executed after onLoad',
        'beforeRender'  => 'Executed before onLoad',
        'onRender'      => 'RETURN_CALL',
        'afterRender'   => 'Executed after onRender',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);
