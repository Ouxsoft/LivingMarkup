<?php
/*
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2021 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Tests\Unit;

use Ouxsoft\LivingMarkup\Contract\BuilderInterface;
use Ouxsoft\LivingMarkup\Contract\ConfigurationInterface;
use Ouxsoft\LivingMarkup\Contract\KernelInterface;
use Ouxsoft\LivingMarkup\Engine;
use Ouxsoft\LivingMarkup\Configuration;
use Ouxsoft\LivingMarkup\Factory\ConcreteFactory;
use Ouxsoft\LivingMarkup\Factory\ContainerFactory;
use Ouxsoft\LivingMarkup\Document;
use PHPUnit\Framework\TestCase;
use Ouxsoft\LivingMarkup\Exception\Exception;

class KernelTest extends TestCase
{
    private $kernel;

    public function setUp(): void
    {
        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);

        //$container['config']->loadFile(TEST_DIR . 'Resource/config/phpunit.json');
        $container['config']->setMarkup('<html><p>Hello, World!</p></html>');
        $this->kernel = &$container['kernel'];
    }

    public function tearDown(): void
    {
        unset($this->kernel);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Kernel::__construct
     * @covers \Ouxsoft\LivingMarkup\Kernel
     */
    public function test__construct()
    {
        $this->assertInstanceOf(KernelInterface::class, $this->kernel);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Kernel::getConfig
     */
    public function testGetConfig()
    {
        $kernel_config = $this->kernel->getConfig();
        $this->assertInstanceOf(ConfigurationInterface::class, $kernel_config);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Kernel::setConfig
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
     * @covers \Ouxsoft\LivingMarkup\Kernel::setBuilder
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
     * @covers \Ouxsoft\LivingMarkup\Kernel::getBuilder
     */
    public function testGetBuilder()
    {
        $builder = $this->kernel->getBuilder();
        $this->assertInstanceOf(BuilderInterface::class, $builder);
    }


    /**
     * @covers \Ouxsoft\LivingMarkup\Kernel::build
     */
    public function testBuild()
    {
        $engine = $this->kernel->build();
        $this->assertInstanceOf(Engine::class, $engine);
    }
}
