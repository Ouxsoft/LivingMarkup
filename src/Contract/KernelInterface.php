<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Contract;

use Ouxsoft\LivingMarkup\Engine;

/**
 * Interface KernelInterface
 * @package Ouxsoft\LivingMarkup\Contract
 */
interface KernelInterface
{
    /**
     * KernelInterface constructor.
     * @param EngineInterface $engine
     * @param BuilderInterface $builder
     * @param ConfigurationInterface $config
     */
    public function __construct(
        EngineInterface &$engine,
        BuilderInterface &$builder,
        ConfigurationInterface &$config
    );

    /**
     * @return ConfigurationInterface
     */
    public function getConfig(): ConfigurationInterface;

    /**
     * @param ConfigurationInterface $config
     */
    public function setConfig(ConfigurationInterface $config): void;

    /**
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface;

    /**
     * @param string $builder_class
     */
    public function setBuilder(string $builder_class): void;

    /**
     * @return Engine
     */
    public function build(): Engine;
}
