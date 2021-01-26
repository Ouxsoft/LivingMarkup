<?php
/**
* This file is part of the LivingMarkup package.
*
* (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace LivingMarkup\Test\LivingMarkup\Tests;

use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Configuration;
use LivingMarkup\Factory\ConcreteFactory;
use LivingMarkup\Factory\ContainerFactory;
use LivingMarkup\Kernel;
use LivingMarkup\Engine;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{

    private $kernel;

    public function setUp() : void
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);
        $container['config']->loadSource(TEST_DIR . 'Resources/config/phpunit.json');
        $container['config']->add('markup', '<html><p>Hello, World!</p></html>');

        $this->kernel = new Kernel(
            $container['engine'],
            $container['builder']
        );
    }

    public function tearDown() : void
    {
        unset($this->processor);
    }


    /**
     * @covers \LivingMarkup\Kernel::setConfig
     */
    public function testSetConfig()
    {
        $document = new Document;
        $config = new Configuration($document);
        $this->kernel->setConfig($config);
        $kernel_config = $this->kernel->getConfig($config);
        $this->assertInstanceOf(Configuration::class, $kernel_config);
    }

    /**
     * @covers \LivingMarkup\Kernel::setBuilder
     */
    public function testSetBuilder()
    {
        $this->kernel->setBuilder('SearchIndexBuilder');
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);
    }

    /**
     * @covers \LivingMarkup\Kernel::build
     */
    public function testBuild()
    {
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);
    }
}
