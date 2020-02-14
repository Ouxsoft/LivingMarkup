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

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

function call_director($buffer)
{
    // instantiate Director
    $director = new LivingMarkup\Director();

    // instantiate Builder
    $builder = new LivingMarkup\Builder\DynamicPageBuilder();

    // load config
    $config = \LivingMarkup\Configuration::load();
    $config['markup'] = $buffer;

    // echo Director build of Builder
    return $director->build($builder, $config);
}

ob_start('call_director');
