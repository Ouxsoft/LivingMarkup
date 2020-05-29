<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

class Autoloader {

    const PROCESS_TOGGLE = 'LHTML_OFF';

    /**
     * Autoloader constructor.
     */
    public function __construct(){
        if (defined(self::PROCESS_TOGGLE )) {
            return;
        }

        // process buffer once completed
        ob_start([$this, 'process']);
    }

    /**
     * Add a module to config
     * @param array $module
     * @return bool
     */
    function addModule(array $module): bool
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
    function process(string $buffer) : string
    {
        global $add_modules;

        // return buffer if it's not HTML
        if ($buffer==strip_tags($buffer)) {
            return $buffer;
        }

        // instantiate Kernel
        $kernel = new Kernel();

        // instantiate Builder
        $builder = new Builder\DynamicPageBuilder();

        // load config
        $config = new Configuration();

        // add runtime modules to config
        if (isset($add_modules)) {
            $config->addModules($add_modules);
        }

        // add buffer to config
        $config->add('markup', $buffer);

        // echo Kernel build of Builder
        return $kernel->build($builder, $config);
    }

}
