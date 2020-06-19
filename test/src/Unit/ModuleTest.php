<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Command\LintCommand;

class ModuleTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Module::getArgByName
     */
    public function testGetArgByName()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $module->args['test'] = 'pass';
        $this->assertEquals('pass', $module->getArgByName('test'));
    }

    /**
     * @covers \LivingMarkup\Module::__construct
     */
    public function test__construct()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $this->assertTrue(isset($module->module_id));
    }

    /**
     * @covers \LivingMarkup\Module::onRender
     */
    public function testOnRender()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $this->assertTrue($module('onRender'));
    }

    /**
     * @covers \LivingMarkup\Module::__invoke
     */
    public function test__invoke()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $this->assertTrue($module('onRender'));
    }

    /**
     * @covers \LivingMarkup\Module::innerText
     */
    public function testInnerText()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $module->xml = 'pass';
        $this->assertStringContainsString($module->innerText(),'pass');
    }

    /**
     * @covers \LivingMarkup\Module::__toString
     */
    public function test__toString()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $this->assertStringContainsString('Hello, World', $module);
    }

    /**
     * @covers \LivingMarkup\Module::getArgs
     */
    public function testGetArgs()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $module->args['test'] = 'pass';
        $this->assertArrayHasKey('test', $module->getArgs());

    }

    /**
     * @covers \LivingMarkup\Module::getId
     */
    public function testGetId()
    {
        $module = new \LivingMarkup\Test\HelloWorld();
        $this->assertIsString($module->getId());

    }
}
