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
 * This example shows how to build a dynamic page using PXP
 */

require '../../vendor/autoload.php';

// instantiate Director
$director = new Pxp\Director();

// instantiate Builder
$builder = new Pxp\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//img'         => 'Pxp\Component\Img',
        '//a'           => 'Pxp\Component\A',
        '//widget'      => 'Pxp\Component\Widgets\{name}',
        '//var'         => 'Pxp\Component\Variable',
        '//condition'   => 'Pxp\Component\Condition',
        '//redacted'    => 'Pxp\Component\Redacted'
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
