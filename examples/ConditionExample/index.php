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
 * This example shows how conditional statements can be made using PXP
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require '../../vendor/autoload.php';

// instantiate Director
$director = new Pxp\Director();

// instantiate PageBuilder
$builder = new Pxp\Builder\DynamicPageBuilder();

// define a datetime to allow consistent display results
// comment out to default to NOW
define('PXP_DATETIME', '2019-12-03 01:30:00');

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//condition'   => 'Pxp\Component\Condition',
    ],
    'hooks' => [
        'onRender'      => 'RETURN_CALL',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);
