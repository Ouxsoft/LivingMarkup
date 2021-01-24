<?php

declare(strict_types=1);

namespace LivingMarkup\Factory;

use DOMDocument;
use DOMXPath;
use LivingMarkup\Builder\BuilderInterface;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Configuration;
use LivingMarkup\Contract\AbstractFactoryInterface;
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
    public function makeConfig(?string $config_file_path = null): Configuration
    {
        $config = new Configuration();

        if($config_file_path !== null){
            $config->loadFile($config_file_path);
        } else {
            $config->setSource('<html></html>');
        }

        return $config;
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
    public function makeDocument(Container &$container): Document
    {
        return new Document();
    }

    /**
     * @inheritDoc
     */
    public function makeDomXpath(Container &$container): DOMXPath
    {
        return new DOMXPath($container['document']);
    }

    /**
     * @inheritDoc
     */
    public function makeBuilder(Container &$container) : BuilderInterface
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
            $container['dom_xpath'],
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


