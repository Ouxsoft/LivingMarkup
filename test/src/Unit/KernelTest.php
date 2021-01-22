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

    /**
     * @covers \LivingMarkup\Kernel::build
     */
    public function testBuild()
    {

        $abstractFactory = new ConcreteFactory();

        $container = ContainerFactory::buildContainer($abstractFactory);
        $container['config'] = new Configuration(TEST_DIR . 'Resources/config/phpunit.json');
        $container['config']->add('markup', '<html><p>Hello, World!</p></html>');

        $kernel = new Kernel(
            $container['engine'],
            $container['builder']
        );

        $builder = new DynamicPageBuilder(
            $container['engine'],
            $container['config']
        );

        $engine = $kernel->build();

        $this->assertInstanceOf(Engine::class, $engine);
    }
}
