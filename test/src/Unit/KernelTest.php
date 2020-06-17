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
        $config_dir = dirname(__DIR__, 1) . '/inputs/phpunit.yml';
        $config = new Configuration($config_dir);
        $config->add('markup', '<html><p>Hello, World!</p></html>');

        $builder = new DynamicPageBuilder();
        $new_page = (new Kernel())->build($builder, $config);

        $this->assertInstanceOf(Engine::class, $new_page);
    }
}
