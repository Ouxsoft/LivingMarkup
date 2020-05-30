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

/**
 * Class Processor
 * @package LivingMarkup
 */
class Processor
{

    const PROCESS_TOGGLE = 'LHTML_OFF';
    const DEBUG = true;

    private $kernel;
    private $builder;
    private $config;

    /**
     * Autoloader constructor.
     */
    public function __construct()
    {

        // instantiate Kernel
        $this->kernel = new Kernel();

    }

    /**
     * Set builder
     * @param $builder
     */
    public function setBuilder($builder = null)
    {
        if ($builder == null) {
            $this->builder = new Builder\DynamicPageBuilder();
            return;
        }

        $this->builder = $builder;
    }

    /**
     * Set config
     * @param $path
     */
    public function setConfig($path){

        global $add_modules;

        // load config
        $this->config = new Configuration($path);

    }

    /**
     * Process output buffer
     */
    public function runBuffer(){
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

        // add buffer to config
        $this->config->add('markup', $buffer);

        // add runtime modules to config
        if (isset($add_modules)) {
            $this->config->addModules($add_modules);
        }

        // echo Kernel build of Builder
        return $this->kernel->build($this->builder, $this->config) . '<!-- LHTML Processor: Success -->';
    }

}
