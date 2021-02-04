<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use LivingMarkup\Contract\AbstractFactoryInterface;
use LivingMarkup\Contract\BuilderInterface;
use LivingMarkup\Contract\DocumentInterface;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Configuration;
use LivingMarkup\Document;
use LivingMarkup\Element\ElementPool;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;
use Pimple\Container;

class ConcreteFactory implements AbstractFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function makeDocument(Container &$container): DocumentInterface
    {
        return new Document();
    }

    /**
     * @inheritDoc
     */
    public function makeConfig(Container &$container): Configuration
    {
        return new Configuration(
            $container['document']
        );
    }

    /**
     * @inheritDoc
     */
    public function makeElementPool(): ElementPool
    {
        return new ElementPool();
    }


    /**
     * @inheritDoc
     */
    public function makeBuilder(Container &$container): BuilderInterface
    {
        return new DynamicPageBuilder(
            $container['engine'],
            $container['config']
        );
    }

    /**
     * @inheritDoc
     */
    public function makeEngine(Container &$container): Engine
    {
        return new Engine(
            $container['document'],
            $container['element_pool']
        );
    }

    /**
     * @inheritDoc
     */
    public function makeKernel(Container &$container): Kernel
    {
        return new Kernel(
            $container['engine'],
            $container['builder'],
            $container['config']
        );
    }
}


