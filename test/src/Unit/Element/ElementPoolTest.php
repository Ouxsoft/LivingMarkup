<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test\Element;

use ArrayIterator;
use LivingMarkup\Element\AbstractElement;
use LivingMarkup\Element\ElementPool;
use LivingMarkup\Test\HelloWorld;
use PHPUnit\Framework\TestCase;

class ElementPoolTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Element\ElementPool::getIterator
     */
    public function testGetIterator()
    {
        $pool = new ElementPool;
        $this->assertTrue(($pool->getIterator() instanceof ArrayIterator));
    }

    /**
     * @covers \LivingMarkup\Element\ElementPool::getPropertiesById
     */
    public function testGetPropertiesById()
    {
        $pool = new ElementPool;
        $lhtml_element = new HelloWorld();
        $pool->add($lhtml_element);
        $this->assertIsArray($pool->getPropertiesById($lhtml_element->element_id));
    }

    /**
     * @covers \LivingMarkup\Element\ElementPool::getById
     */
    public function testGetById()
    {
        $pool = new ElementPool;
        $lhtml_element = new HelloWorld();
        $pool->add($lhtml_element);
        $this->assertTrue(($pool->getById($lhtml_element->element_id) instanceof AbstractElement));

        $this->assertFalse(($pool->getById('missing') instanceof AbstractElement));
    }

    /**
     * @covers \LivingMarkup\Element\ElementPool::add
     */
    public function testAdd()
    {
        $pool = new ElementPool;
        $lhtml_element = new HelloWorld();
        $pool->add($lhtml_element);
        $this->assertTrue(($pool->getById($lhtml_element->element_id) instanceof AbstractElement));
    }

    /**
     * @covers \LivingMarkup\Element\ElementPool::callRoutine
     */
    public function testCallRoutine()
    {
        $pool = new ElementPool();
        $results = $pool->callRoutine('onRender');
        $this->assertNull($results);
    }

    /**
     * @covers \LivingMarkup\Element\ElementPool::count
     */
    public function testCount()
    {
        $pool = new ElementPool;
        $lhtml_element = new HelloWorld();
        $pool->add($lhtml_element);
        $this->assertCount(1, $pool);
    }
}
