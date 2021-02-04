<?php

namespace LivingMarkup\Contract;

use LivingMarkup\Contract\BuilderInterface;
use LivingMarkup\Configuration;
use LivingMarkup\Document;
use LivingMarkup\Element\ElementPool;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;
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