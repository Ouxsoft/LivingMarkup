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
use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\KernelInterface;

/**
 * Class Processor
 *
 * @package LivingMarkup
 */
class Processor
{
    // determines if process is active
    private $active = true;
    private $config;
    private $kernel;

    /**
     * Processor constructor.
     * @param KernelInterface $kernel
     * @param ConfigurationInterface $config
     */
    public function __construct(
        KernelInterface &$kernel,
        ConfigurationInterface &$config
    )
    {
        $this->kernel = &$kernel;
        $this->config = &$config;
    }

    /**
     * Set whether process runs or does not run
     *
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->active = $status;
    }

    /**
     * Load config
     *
     * @param $filepath
     */
    public function loadConfig(string $filepath): void
    {
        $this->config->loadFile($filepath);
    }

    /**
     * Get config
     *
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param ConfigurationInterface $config
     * @return void
     */
    public function setConfig(ConfigurationInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * Set builder
     *
     * @param string $builder_class
     */
    public function setBuilder(string $builder_class): void
    {
        $this->kernel->setBuilder($builder_class);
    }

    /**
     * Get builder
     *
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface
    {
        return $this->kernel->getBuilder();
    }

    /**
     * Add definition for processor LHTML object
     *
     * @param string $name
     * @param string $xpath_expression
     * @param string $class_name
     */
    public function addElement(string $name, string $xpath_expression, string $class_name): void
    {
        $this->config->addElement([
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
    public function addMethod(string $method_name, string $description = '', string $execute = null): void
    {
        $this->config->addMethod($method_name, $description, $execute);
    }

    /**
     * Process output buffer
     */
    public function parseBuffer(): void
    {
        if ($this->getStatus()) {
            // process buffer once completed
            ob_start([$this, 'parseString']);
        }
    }

    /**
     * Gets whether process runs or does not run
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->active;
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
     * Parse using a Kernel to build an Engine
     *
     * @return string
     */
    private function parse(): string
    {
        return (string)$this->kernel->build();
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
}
