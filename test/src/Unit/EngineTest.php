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
use LivingMarkup\Engine;
use LivingMarkup\Exception\Exception;
use LivingMarkup\Processor;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    /**
     * @covers \LivingMarkup\Engine::setType
     */
    public function testSetType()
    {
        $config = new Configuration();
        $engine = new Engine($config);

        $results = $engine->setType('0', 'string');
        $this->assertIsString($results);

        $results = $engine->setType('2', 'int');
        $this->assertIsInt($results);

        $results = $engine->setType('1', 'bool');
        $this->assertIsBool($results);

        $results = $engine->setType('1.1', 'float');
        $this->assertIsFloat($results);

        $results = $engine->setType('', 'null');
        $this->assertNull($results);

        $results = $engine->setType('Cat,Dog,Pig', 'list');
        $this->assertIsArray($results);

        $results = $engine->setType('["Cat","Dog","Pig"]', 'json');
        $this->assertIsArray($results);
    }

    /**
     * @covers \LivingMarkup\Engine::queryFetchAll
     */
    public function testQueryFetchAll()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->queryFetchAll('//*');
        $this->assertCount(2, $results);
    }

    /**
     * @covers \LivingMarkup\Engine::getDomElementByPlaceholderId
     */
    public function testGetDomElementByPlaceholderId()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test">Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->getDomElementByPlaceholderId('test');
        $bool = ($results->getAttribute(Engine::INDEX_ATTRIBUTE) == 'test') ? true : false;
        $this->assertTrue($bool);
    }

    /**
     * @covers \LivingMarkup\Engine::getElementInnerXML
     */
    public function testGetElementInnerXML()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test">Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->getElementInnerXML('test');
        $bool = ($results == 'Hello, World!') ? true : false;
        $this->assertTrue($bool);
    }

    /**
     * @covers \LivingMarkup\Engine::getElementArgs
     */
    public function testGetElementArgs()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test"><arg name="toggle">no</arg><arg name="">empty</arg></b></html>');
        $engine = new Engine($config);
        $dom_element = $engine->getDomElementByPlaceholderId('test');
        $args = $engine->getElementArgs($dom_element);
        $bool = ($args['toggle'] == 'no') ? true : false;
        $this->assertTrue($bool);


    }

    /**
     * @covers \LivingMarkup\Engine::__toString
     */
    public function test__toString()
    {
        $test_results = '<!DOCTYPE html>
<html><b><arg name="toggle">no</arg></b></html>
';
        $config = new Configuration();
        $config->setSource('<html><b><arg name="toggle">no</arg></b></html>');
        $engine = (string) new Engine($config);
        $bool = ($engine == $test_results ? true : false);
        $this->assertTrue($bool);
    }

    /**
     * @covers \LivingMarkup\Engine::queryFetch
     */
    public function testQueryFetch()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->queryFetch('//*');
        $bool = ($results->nodeValue == 'Hello, World!') ? true : false;
        $this->assertTrue($bool);
    }

    /**
     * @covers \LivingMarkup\Engine::instantiateElements
     */
    public function testInstantiateElements()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        $this->assertCount(1, $engine->element_pool);

        $engine->instantiateElements(
            [
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );

        $bool = $engine->instantiateElements([]);

        $this->assertFalse($bool);

    }

    /**
     * @covers \LivingMarkup\Engine::callMethod
     */
    public function testCallMethod()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $engine->instantiateElements(
            [
                'xpath' => '//b',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        $bool = $engine->callMethod([
            'name' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $this->assertTrue($bool);

        $throw_occurred = false;
        try {
            // test throw
            $engine->callMethod([
                'name' => 'onRender',
                'execute' => 'THROW_ERROR'
            ]);
        } catch (Exception $e) {
            $throw_occurred = true;
        }
        $this->assertTrue($throw_occurred);
    }


    /**
     * @covers \LivingMarkup\Engine::replaceDomElement
     */
    public function testReplaceDomElement()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test"><arg name="toggle">no</arg></b></html>');
        $engine = new Engine($config);
        $dom_element = $engine->getDomElementByPlaceholderId('test');
        $engine->replaceDomElement($dom_element, '<b>Foo Bar</b>');
        $this->assertStringContainsString($engine, '<!DOCTYPE html>
<html><b>Foo Bar</b></html>
');
    }

    /**
     * @covers \LivingMarkup\Engine::renderElement
     */
    public function testRenderElement()
    {
        $config = new Configuration();
        $config->setSource('<html><div>Foo Bar</div></html>');
        $engine = new Engine($config);
        $engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        foreach($engine->element_pool as $element){

            $engine->renderElement($element->element_id);

        }

        $this->assertStringContainsString($engine, '<!DOCTYPE html>
<html>Hello, World</html>
');

        // try tendering invalid element
        $bool = $engine->renderElement('2');
        $this->assertFalse($bool);

    }

    /**
     * private class cannot test directly, instead we're using InstantiateElements
     * @covers \LivingMarkup\Engine::instantiateElement
     */
    public function testInstantiateElement()
    {
        $config = new Configuration();
        $config->setSource('
<html>
    <div ' . Engine::INDEX_ATTRIBUTE . '="skip">
        Skip
    </div>
    <div name="HelloWorld" type="page">
        <arg name="section">help</arg>
        <div>Hello, World!</div>
    </div>
    <em name="test">Foo Bar</em>
</html>');
        $engine = new Engine($config);
        $engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'LivingMarkup\Test\{name}'
            ]
        );
        $engine->instantiateElements([
            'xpath' => '//em',
            'class_name' => 'Missing'
        ]);

        $this->assertCount(1, $engine->element_pool);
    }

    /**
     * @covers \LivingMarkup\Engine::getElementAncestorProperties
     */
    public function testGetElementAncestorProperties()
    {
        $config = new Configuration();
        $config->setSource('<html><div type="page"><arg name="section">help</arg><div>Hello, World!</div></div></html>');
        $engine = new Engine($config);
        $engine->instantiateElements(
            [
                'xpath' => '//div',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        foreach ($engine->element_pool as $element) {
            $properties = $engine->getElementAncestorProperties($element->element_id);
            $this->assertIsArray($properties);
        }

    }

    /**
     * @covers \LivingMarkup\Engine::__construct
     */
    public function test__construct()
    {
        $config = new Configuration();
        $engine = new Engine($config);
        $bool = ($engine->element_pool instanceof \LivingMarkup\Element\ElementPool) ? true : false;
        $this->assertTrue($bool);
    }
}
