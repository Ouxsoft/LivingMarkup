<?php

namespace LivingMarkup\Contract;

use DOMDocument;
use DOMXPath;
use LivingMarkup\Configuration;
use LivingMarkup\Element\ElementPool;
use LivingMarkup\Document;
use LivingMarkup\Builder\BuilderInterface;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;
use Pimple\Container;

interface AbstractFactoryInterface
{
    /**
     * @param string|null $config_file_path
     * @return Configuration
     */
    public function makeConfig(?string $config_file_path = null): Configuration;

    /**
     * @return ElementPool
     */
    public function makeElementPool(): ElementPool;

    /**
     * @param Container $container
     * @return Document
     */
    public function makeDocument(Container &$container): Document;

    /**
     * @param Container $container
     * @return DOMXPath
     */
    public function makeDomXpath(Container &$container): DOMXPath;

    /**
     * @param Container $container
     * @return BuilderInterface
     */
    public function makeBuilder(Container &$container) : BuilderInterface;

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