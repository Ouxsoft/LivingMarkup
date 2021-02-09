<?php

namespace Ouxsoft\LivingMarkup\Contract;

use Ouxsoft\LivingMarkup\Contract\BuilderInterface;
use Ouxsoft\LivingMarkup\Configuration;
use Ouxsoft\LivingMarkup\Document;
use Ouxsoft\LivingMarkup\Element\ElementPool;
use Ouxsoft\LivingMarkup\Engine;
use Ouxsoft\LivingMarkup\Kernel;
use Pimple\Container;

interface AbstractFactoryInterface
{
    /**
     * @param Container $container
     * @return Document
     */
    public function makeDocument(Container &$container): DocumentInterface;

    /**
     * @param Container $container
     * @return Configuration
     */
    public function makeConfig(Container &$container): Configuration;

    /**
     * @return ElementPool
     */
    public function makeElementPool(): ElementPool;

    /**
     * @param Container $container
     * @return BuilderInterface
     */
    public function makeBuilder(Container &$container): BuilderInterface;

    /**
     * @param Container $container
     * @return Engine
     */
    public function makeEngine(Container &$container): Engine;

    /**
     * @param Container $container
     * @return Kernel
     */
    public function makeKernel(Container &$container): Kernel;
}