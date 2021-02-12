<?php

declare(strict_types=1);

namespace Ouxsoft\LivingMarkup\Factory;

use Ouxsoft\LivingMarkup\Contract\AbstractFactoryInterface;
use Ouxsoft\LivingMarkup\Contract\BuilderInterface;
use Ouxsoft\LivingMarkup\Contract\DocumentInterface;
use Ouxsoft\LivingMarkup\Builder\DynamicPageBuilder;
use Ouxsoft\LivingMarkup\Configuration;
use Ouxsoft\LivingMarkup\Document;
use Ouxsoft\LivingMarkup\Element\ElementPool;
use Ouxsoft\LivingMarkup\Engine;
use Ouxsoft\LivingMarkup\Kernel;
use Pimple\Container;

class ConcreteFactory implements AbstractFactoryInterface
{

    public function makeDocument(Container &$container): DocumentInterface
    {
        return new Document();
    }


    public function makeConfig(Container &$container): Configuration
    {
        return new Configuration(
            $container['document']
        );
    }

    public function makeElementPool(): ElementPool
    {
        return new ElementPool();
    }


    public function makeBuilder(Container &$container): BuilderInterface
    {
        return new DynamicPageBuilder(
            $container['engine'],
            $container['config']
        );
    }

    public function makeEngine(Container &$container): Engine
    {
        return new Engine(
            $container['document'],
            $container['element_pool']
        );
    }

    public function makeKernel(Container &$container): Kernel
    {
        return new Kernel(
            $container['engine'],
            $container['builder'],
            $container['config']
        );
    }
}


