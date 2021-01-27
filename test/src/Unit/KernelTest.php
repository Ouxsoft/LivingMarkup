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

use LivingMarkup\Builder\BuilderInterface;
use LivingMarkup\Configuration;
use LivingMarkup\Contract\ConfigurationInterface;
use LivingMarkup\Contract\KernelInterface;
use LivingMarkup\Engine;
use LivingMarkup\Factory\ConcreteFactory;
use LivingMarkup\Factory\ContainerFactory;
use LivingMarkup\Document;
use PHPUnit\Framework\TestCase;
use LivingMarkup\Exception\Exception;

class KernelTest extends TestCase
{

    private $kernel;

    public function setUp() : void
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);

        $container['config']->loadFile(TEST_DIR . 'Resource/config/phpunit.json');
        $container['config']->setMarkup('<html><p>Hello, World!</p></html>');
        $this->kernel = &$container['kernel'];
    }

    public function tearDown() : void
    {
        unset($this->kernel);
    }

    /**
     * @covers \LivingMarkup\Kernel::__construct
     */
    public function test__construct()
    {
        $this->assertInstanceOf(KernelInterface::class, $this->kernel);
    }

    /**
     * @covers \LivingMarkup\Kernel::getConfig
     */
    public function testGetConfig()
    {
        $kernel_config = $this->kernel->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $kernel_config);
    }

    /**
     * @covers \LivingMarkup\Kernel::setConfig
     */
    public function testSetConfig()
    {
        $document = new Document();
        $config = new Configuration($document);
        $this->kernel->setConfig($config);
        $kernel_config = $this->kernel->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $kernel_config);
    }

    /**
     * @covers \LivingMarkup\Kernel::setBuilder
     */
    public function testSetBuilder()
    {
        $this->kernel->setBuilder('SearchIndexBuilder');
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);

        // try a class that doesn't exists
        $this->expectException(Exception::class);
        $this->kernel->setBuilder('DoesNotExists');

        // try a class that is doesn't implement BuilderInterface
        $this->expectException(Exception::class);
        $this->kernel->setBuilder('ElementPool');
    }

    /**
     * @covers \LivingMarkup\Kernel::getBuilder
     */
    public function testGetBuilder()
    {
        $builder = $this->kernel->getBuilder();
        $this->assertInstanceOf(BuilderInterface::class, $builder);
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
