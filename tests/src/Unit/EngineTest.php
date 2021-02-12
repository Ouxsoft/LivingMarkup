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

use Ouxsoft\LivingMarkup\Element\ElementPool;
use Ouxsoft\LivingMarkup\Engine;
use Ouxsoft\LivingMarkup\Exception\Exception;
use Ouxsoft\LivingMarkup\Factory\ConcreteFactory;
use Ouxsoft\LivingMarkup\Factory\ContainerFactory;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    private $engine;
    private $config;

    public function setUp(): void
    {
        $abstractFactory = new ConcreteFactory();
        $container = ContainerFactory::buildContainer($abstractFactory);
        $this->engine = &$container['engine'];
        $this->config = &$container['config'];
    }

    public function tearDown(): void
    {
        unset($this->engine);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::setType
     */
    public function testSetType()
    {
        $results = $this->engine->setType('0', 'string');
        $this->assertIsString($results);

        $results = $this->engine->setType('2', 'int');
        $this->assertIsInt($results);

        $results = $this->engine->setType('1', 'bool');
        $this->assertIsBool($results);

        $results = $this->engine->setType('1.1', 'float');
        $this->assertIsFloat($results);

        $results = $this->engine->setType('', 'null');
        $this->assertNull($results);

        $results = $this->engine->setType('Cat,Dog,Pig', 'list');
        $this->assertIsArray($results);

        $results = $this->engine->setType('["Cat","Dog","Pig"]', 'json');
        $this->assertIsArray($results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::queryFetchAll
     */
    public function testQueryFetchAll()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $results = $this->engine->queryFetchAll('//*');
        $this->assertCount(2, $results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::getDomElementByPlaceholderId
     */
    public function testGetDomElementByPlaceholderId()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test">Hello, World!</b></html>');
        $results = $this->engine->getDomElementByPlaceholderId('test');
        $bool = $results->getAttribute(Engine::INDEX_ATTRIBUTE) == 'test';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::getElementInnerXML
     */
    public function testGetElementInnerXML()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test">Hello, World!</b></html>');
        $results = $this->engine->getElementInnerXML('test');
        $bool = $results == 'Hello, World!';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::getElementArgs
     */
    public function testGetElementArgs()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test"><arg name="toggle">no</arg><arg name="">empty</arg></b></html>');
        $dom_element = $this->engine->getDomElementByPlaceholderId('test');
        $args = $this->engine->getElementArgs($dom_element);
        $bool = $args['toggle'] == 'no';
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::__toString
     */
    public function test__toString()
    {
        $this->config->setMarkup('<html lang="en"><b><arg name="toggle">no</arg></b></html>');
        $engine = (string)$this->engine;
        $engine = $this->removeWhitespace($engine);
        $test_results = '<!DOCTYPE html><html lang="en"><b><arg name="toggle">no</arg></b></html>';
        $this->assertEquals($engine, $test_results);
    }

    /**
     * Removes whitespace to allow testing from multiple OS
     * @param string $string
     * @return string
     */
    public function removeWhitespace(string $string): string
    {
        return preg_replace('~\R~u', '', $string);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::queryFetch
     */
    public function testQueryFetch()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $results = $this->engine->queryFetch('//*');
        $this->assertEquals('Hello, World!', $results->nodeValue);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::instantiateElements
     */
    public function testInstantiateElements()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        $this->assertCount(1, $this->engine->element_pool);

        $this->engine->instantiateElements(
            [
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );

        $bool = $this->engine->instantiateElements([]);

        $this->assertFalse($bool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::callRoutine
     */
    public function testCallRoutine()
    {
        $this->config->setMarkup('<html lang="en"><b>Hello, World!</b></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        $bool = $this->engine->callRoutine([
            'name' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $this->assertTrue($bool);

        $throw_occurred = false;
        try {
            // test throw
            $this->engine->callRoutine([
                'name' => 'onRender',
                'execute' => 'THROW_ERROR'
            ]);
        } catch (Exception $e) {
            $throw_occurred = true;
        }
        $this->assertTrue($throw_occurred);
    }


    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::replaceDomElement
     */
    public function testReplaceDomElement()
    {
        $this->config->setMarkup('<html lang="en"><b ' . Engine::INDEX_ATTRIBUTE . '="test"><arg name="toggle">no</arg></b></html>');
        $dom_element = $this->engine->getDomElementByPlaceholderId('test');
        $this->engine->replaceDomElement($dom_element, '<b>Foo Bar</b>');
        $engine_output = $this->removeWhitespace($this->engine);
        $this->assertStringContainsString(
            $engine_output,
            '<!DOCTYPE html><html lang="en"><b>Foo Bar</b></html>'
        );
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::renderElement
     */
    public function testRenderElement()
    {
        $this->config->setMarkup('<html lang="en"><div>Foo Bar</div></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        foreach ($this->engine->element_pool as $element) {
            $this->engine->renderElement($element->element_id);
        }

        $engine_output = $this->removeWhitespace($this->engine);

        $this->assertStringContainsString(
            $engine_output,
            '<!DOCTYPE html><html lang="en">Hello, World</html>'
        );

        // try tendering invalid element
        $bool = $this->engine->renderElement('2');
        $this->assertFalse($bool);
    }

    /**
     * private class cannot test directly, instead we're using InstantiateElements
     * @covers \Ouxsoft\LivingMarkup\Engine::instantiateElement
     */
    public function testInstantiateElement()
    {
        $this->config->setMarkup('
<html lang="en">
    <div ' . Engine::INDEX_ATTRIBUTE . '="skip">
        Skip
    </div>
    <div name="HelloWorld" type="page">
        <arg name="section">help</arg>
        <div>Hello, World!</div>
    </div>
    <em name="test">Foo Bar</em>
</html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\{name}'
            ]
        );
        $this->engine->instantiateElements([
            'xpath' => '//em',
            'class_name' => 'Missing'
        ]);

        $this->assertCount(1, $this->engine->element_pool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::getElementAncestorProperties
     */
    public function testGetElementAncestorProperties()
    {
        $this->config->setMarkup('<html lang="en"><div type="page"><arg name="section">help</arg><div>Hello, World!</div></div></html>');
        $this->engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'Ouxsoft\LivingMarkup\Tests\Resource\Element\HelloWorld'
            ]
        );
        foreach ($this->engine->element_pool as $element) {
            $properties = $this->engine->getElementAncestorProperties($element->element_id);
            $this->assertIsArray($properties);
        }
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Engine::__construct
     */
    public function test__construct()
    {
        $bool = $this->engine->element_pool instanceof ElementPool;
        $this->assertTrue($bool);
    }
}
