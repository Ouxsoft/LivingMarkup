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

// instantiate PageDirector
$director = new Pxp\Page\PageDirector();

// instantiate PageBuilder
$page_builder = new Pxp\Page\Builder\DynamicBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//img'         => 'Pxp\DynamicElement\Img',
        '//a'           => 'Pxp\DynamicElement\A',
        '//widget'      => 'Pxp\DynamicElement\Widgets\{name}',
        '//var'         => 'Pxp\DynamicElement\Variable',
        '//condition'   => 'Pxp\DynamicElement\Condition',
        '//redacted'    => 'Pxp\DynamicElement\Redacted'
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

// echo PageDirector build PageBuilder
echo $director->build($page_builder, $parameters);
