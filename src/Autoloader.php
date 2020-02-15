<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use LivingMarkup;

function add_module(array $module): bool
{
    global $add_modules;

    if (!array_key_exists('add_modules', $GLOBALS)) {
        $add_modules = [];
    }
    $add_modules[] = $module;
    return true;
}

function call_kernel(string $buffer)
{
    global $add_modules;

    // return buffer if it's not HTML
    if($buffer==strip_tags($buffer)){
        return $buffer;
    }

    // instantiate Kernel
    $kernel = new LivingMarkup\Kernel();

    // instantiate Builder
    $builder = new LivingMarkup\Builder\DynamicPageBuilder();

    // load config
    $config = \LivingMarkup\Configuration::load();
    $config['markup'] = $buffer;

    // add runtime declared modules to config
    // $GLOBALS['add_modules'] are ordered first so that they are instantiated if same instead of loaded config
    if (
        array_key_exists('add_modules', $GLOBALS) &&
        array_key_exists('modules', $config) &&
        array_key_exists('types', $config['modules'])
    ) {
        $config['modules']['types'] = array_merge($add_modules, $config['modules']['types']);
    }

    /*
    // uncomment line to debug runtime config
    $config['markup'] = $buffer . '<!-- '. var_export($config, true).'-->';
    */

    // echo Kernel build of Builder
    return $kernel->build($builder, $config);
}

ob_start('call_kernel');
