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

use LivingMarkup\Contract\BuilderInterface;
use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\EngineInterface;
use LivingMarkup\Contract\KernelInterface;
use LivingMarkup\Exception\Exception;

/**
 * Class Kernel
 *
 * The Kernel passes a Configuration through a Builder to build a Engine
 *
 * @package LivingMarkup
 */
class Kernel implements KernelInterface
{
    private $engine;
    private $builder;
    private $config;

    /**
     * Kernel constructor.
     * @param EngineInterface $engine
     * @param BuilderInterface $builder
     * @param ConfigurationInterface $config
     */
    public function __construct(
        EngineInterface &$engine,
        BuilderInterface &$builder,
        ConfigurationInterface &$config
    )
    {
        $this->engine = &$engine;
        $this->builder = &$builder;
        $this->config = &$config;
    }

    /**
     * Get config
     *
     * @return ConfigurationInterface
     */
    public function getConfig(): ConfigurationInterface
    {
        return $this->config;
    }

    /**
     * Set config
     *
     * @param ConfigurationInterface $config
     */
    public function setConfig(ConfigurationInterface $config): void
    {
        $this->config = $config;
    }

    /**
     * Get builder
     *
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    /**
     * Set builder
     *
     * @param string $builder_class
     */
    public function setBuilder(string $builder_class): void
    {
        $builder_class = 'LivingMarkup\\Builder\\' . $builder_class;

        if (!class_exists($builder_class)) {
            throw new Exception('Builder class "' . $builder_class . '" does not exists');
        }

        $this->builder = new $builder_class(
            $this->engine,
            $this->config
        );
    }

    /**
     * Calls Builder using parameters supplied
     * @return Engine
     */
    public function build(): Engine
    {
        $this->builder->createObject();

        return $this->builder->getObject();
    }
}
