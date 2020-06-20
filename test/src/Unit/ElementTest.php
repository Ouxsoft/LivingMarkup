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

use LivingMarkup\Test\HelloWorld;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Element::getArgByName
     */
    public function testGetArgByName()
    {
        $element = new HelloWorld();
        $element->args['test'] = 'pass';
        $this->assertEquals('pass', $element->getArgByName('test'));
    }

    /**
     * @covers \LivingMarkup\Element::__construct
     */
    public function test__construct()
    {
        $element = new HelloWorld();
        $this->assertTrue(isset($element->element_id));
    }

    /**
     * @covers \LivingMarkup\Element::onRender
     */
    public function testOnRender()
    {
        $element = new HelloWorld();
        $this->assertTrue($element('onRender'));
    }

    /**
     * @covers \LivingMarkup\Element::__invoke
     */
    public function test__invoke()
    {
        $element = new HelloWorld();
        $this->assertTrue($element('onRender'));
    }

    /**
     * @covers \LivingMarkup\Element::innerText
     */
    public function testInnerText()
    {
        $element = new HelloWorld();
        $element->xml = 'pass';
        $this->assertStringContainsString($element->innerText(),'pass');
    }

    /**
     * @covers \LivingMarkup\Element::__toString
     */
    public function test__toString()
    {
        $element = new HelloWorld();
        $this->assertStringContainsString('Hello, World', $element);
    }

    /**
     * @covers \LivingMarkup\Element::getArgs
     */
    public function testGetArgs()
    {
        $element = new HelloWorld();
        $element->args['test'] = 'pass';
        $this->assertArrayHasKey('test', $element->getArgs());

    }

    /**
     * @covers \LivingMarkup\Element::getId
     */
    public function testGetId()
    {
        $element = new HelloWorld();
        $this->assertIsString($element->getId());

    }
}
