<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup;

use LivingMarkup\Builder\BuilderInterface;

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
     * @param string $config_filepath
     */
    public function __construct(string $config_filepath = null)
    {

        // instantiate Kernel
        $this->kernel = new Kernel();

        // instantiate a empty config
        $this->config = new Configuration();

        // check if config filepath supplied during construction
        if($config_filepath!==null){
            $this->loadConfig($config_filepath);
        }

        // instantiate a default builder
        $this->builder = new Builder\DynamicPageBuilder();

    }

    /**
     * Set builder
     * @param BuilderInterface $builder_class
     */
    public function setBuilder(BuilderInterface $builder_class) : void
    {
        $this->builder =  new $builder_class();

    }

    /**
     * Set config
     * @param $filepath
     */
    public function loadConfig(string $filepath) : void
    {

        // load config
        $this->config->loadFile($filepath);

    }

    /**
     * Get config
     * @return Configuration
     */
    public function getConfig() : Configuration
    {
        return $this->config;
    }

    /**
     * Add a module to config
     * @param array $module
     * @return bool
     */
    public function addModule(array $module): bool
    {
        global $add_modules;

        if (!isset($add_modules)) {
            $add_modules = [];
        }
        $add_modules[] = $module;

        return true;
    }

    /**
     * Add definition for processor LHTML object
     *
     * @param string $name
     * @param string $xpath_expression
     * @param string $class_name
     */
    public function addObject(string $name, string $xpath_expression, string $class_name) : void
    {
        $this->config->addModule([
            'name' => $name,
            'class_name' => $class_name,
            'xpath' => $xpath_expression
        ]);
    }

    /**
     * Add definition for processor LHTML object method
     *
     * @param string $method_name
     * @param string $description
     * @param string|null $execute
     */
    public function addMethod(string $method_name, string $description = '', string $execute = null) : void
    {
        $this->config->addMethod($method_name, $description, $execute);
    }


    /**
     * Process output buffer
     */
    public function parseBuffer() : void
    {
        if (defined(self::PROCESS_TOGGLE)) {
            return;
        }

        // process buffer once completed
        ob_start([$this, 'parseString']);
    }

    /**
     * Process a file
     *
     * @param $filepath
     * @return string
     */
    public function parseFile(string $filepath): string
    {

        $source = file_get_contents($filepath);

        // return buffer if it's not HTML
        if ($source == strip_tags($source)) {
            return $source;
        }

        $this->config->setSource($source);

        return $this->parse();

    }

    /**
     * Process string
     *
     * @param string $source
     * @return string
     */
    public function parseString(string $source): string
    {

        // return buffer if it's not HTML
        if ($source == strip_tags($source)) {
            return $source;
        }

        $this->config->setSource($source);

        return $this->parse();

    }

    private function parse() : string
    {

        // add runtime modules to config
        if (isset($add_modules)) {
            $this->config->addModules($add_modules);
        }

        // echo Kernel build of Builder
        return (string) $this->kernel->build($this->builder, $this->config);

    }
}
