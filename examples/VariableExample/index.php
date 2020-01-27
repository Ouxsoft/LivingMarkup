<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Pxp\Component\Component;

require '../../vendor/autoload.php';
require 'UserProfile.php';
require 'GroupProfile.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// instantiate Director
$director = new Pxp\Director();

// instantiate Builder
$builder = new Pxp\Builder\DynamicPageBuilder();

// define build parameters
$parameters = [
    'filename' => __DIR__ . DIRECTORY_SEPARATOR . 'input.html',
    'handlers' => [
        '//var' => 'Pxp\Component\Variable',
        '//widget' => 'Pxp\Component\Widgets\{name}',
    ],
    'hooks' => [
        'onRender' => 'RETURN_CALL',
    ]
];

// echo Director build PageBuilder
echo $director->build($builder, $parameters);
