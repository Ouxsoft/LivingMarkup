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
 * Add a module to config
 * @param array $module
 * @return bool
 */
function add_module(array $module): bool
{
    global $add_modules;

    if (!isset($add_modules)) {
        $add_modules = [];
    }
    $add_modules[] = $module;
    return true;
}

/**
 * Callback to run kernel
 * @param string $buffer
 * @return string
 */
function call_kernel(string $buffer) : string
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
    $config = new LivingMarkup\Configuration();

    // add runtime modules to config
    if(isset($add_modules)){
        $config->addModules($add_modules);
    }

    // add buffer to config
    $config->add('markup', $buffer);

    // echo Kernel build of Builder
    return $kernel->build($builder, $config);
}

ob_start('call_kernel');
