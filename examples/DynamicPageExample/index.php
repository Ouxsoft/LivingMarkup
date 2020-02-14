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

// load config
$config = LivingMarkup\Configuration::load();
$config['filename'] = __DIR__ . DIRECTORY_SEPARATOR . 'input.html';

echo $director->build($builder, $config);
