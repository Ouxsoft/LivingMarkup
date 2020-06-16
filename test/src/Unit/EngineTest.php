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
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{

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

    public function testQueryFetchAll()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->queryFetchAll('//*');
        $this->assertCount(2, $results);
    }

    public function testGetDomElementByPlaceholderId()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test">Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->getDomElementByPlaceholderId('test');
        $bool = ($results->getAttribute(Engine::INDEX_ATTRIBUTE) == 'test') ? true : false;
        $this->assertTrue($bool);
    }

    public function testGetModuleInnerXML()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test">Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->getModuleInnerXML('test');
        $bool = ($results == 'Hello, World!') ? true : false;
        $this->assertTrue($bool);
    }


    public function testGetElementArgs()
    {
        $config = new Configuration();
        $config->setSource('<html><b '.Engine::INDEX_ATTRIBUTE.'="test"><arg name="toggle">no</arg></b></html>');
        $engine = new Engine($config);
        $dom_element = $engine->getDomElementByPlaceholderId('test');
        $args = $engine->getElementArgs($dom_element);
        $bool = ($args['toggle'] == 'no') ? true : false;
        $this->assertTrue($bool);
    }


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

    public function testQueryFetch()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $results = $engine->queryFetch('//*');
        $bool = ($results->nodeValue == 'Hello, World!') ? true : false;
        $this->assertTrue($bool);
    }

    public function testInstantiateModules()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $engine->instantiateModules(
            [
                'xpath' => '//b',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        $this->assertCount(1, $engine->module_pool);
    }

    public function testCallHook()
    {
        $config = new Configuration();
        $config->setSource('<html><b>Hello, World!</b></html>');
        $engine = new Engine($config);
        $engine->instantiateModules(
            [
                'xpath' => '//b',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        $bool = $engine->callHook([
            'name' => 'onRender',
            'execute' => 'RETURN_CALL'
        ]);
        $this->assertTrue($bool);
    }


    /*
     * // TODO: add following

    public function testReplaceDomElement()
    {

    }

    public function testRenderModule()
    {

    }
    */

    // private class cannot test directly, instead we're using InstantiateModules
    public function testInstantiateModule()
    {

        $config = new Configuration();
        $config->setSource('<html><div type="page"><arg name="section">help</arg><div>Hello, World!</div></div></html>');
        $engine = new Engine($config);
        $engine->instantiateModules(
            [
                'xpath' => '//div',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        $this->assertCount(2, $engine->module_pool);

    }

    public function testGetModuleAncestorProperties()
    {
        $config = new Configuration();
        $config->setSource('<html><div type="page"><arg name="section">help</arg><div>Hello, World!</div></div></html>');
        $engine = new Engine($config);
        $engine->instantiateModules(
            [
                'xpath' => '//div',
                'class_name' => 'LivingMarkup\Test\HelloWorld'
            ]
        );
        foreach($engine->module_pool as $module){
            $properties = $engine->getModuleAncestorProperties($module->module_id);
            $this->assertIsArray($properties);
        }
    }

    public function test__construct()
    {
        $config = new Configuration();
        $engine = new Engine($config);
        $bool = ($engine->module_pool instanceof \LivingMarkup\Module\ModulePool) ? true : false;
        $this->assertTrue($bool);
    }
}