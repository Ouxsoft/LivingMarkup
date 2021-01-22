<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests;

use LivingMarkup\Configuration;
use PHPUnit\Framework\TestCase;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Builder\SearchIndexBuilder;
use LivingMarkup\Builder\StaticPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;

final class BuilderTest extends TestCase
{

    private $config;
    private $markup = '<html><bitwise>
    <arg name="number">2</arg>
    <arg name="count">6</arg>
    <arg name="operator">^</arg>
</bitwise></html>';

    public function setUp() : void
    {
        $config_dir = TEST_DIR . 'Resource/inputs/phpunit.json';
        $this->config = new Configuration($config_dir);
        $this->config->add('markup', $this->markup);
    }

    public function tearDown() : void
    {
        unset($this->config);
    }

    public function testDynamicPageBuilder()
    {
        $builder = new DynamicPageBuilder();
        $new_page = (new Kernel())->build($builder, $this->config);

        $this->assertInstanceOf(Engine::class, $new_page);
    }

    public function testSearchIndexBuilder()
    {
        $builder = new SearchIndexBuilder();
        $new_page = (new Kernel())->build($builder, $this->config);

        $this->assertInstanceOf(Engine::class, $new_page);
    }

    public function testStaticPageBuilder()
    {
        $builder = new StaticPageBuilder();
        $new_page = (new Kernel())->build($builder, $this->config);

        $this->assertInstanceOf(Engine::class, $new_page);
    }
}
