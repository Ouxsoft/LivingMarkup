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

use Ouxsoft\LivingMarkup\ArgumentArray;
use PHPUnit\Framework\TestCase;

class ArgumentArrayTest extends TestCase
{
    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::count
     */
    public function testCount()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::offsetSet
     */
    public function testOffsetSet()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);

        // check to make sure only one item exists
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);


        // check to see if it turns key into an array
        $args->offsetSet('1', 'test_2');
        $this->assertCount(1, $args);
        $this->assertIsArray($args['1']);

        // check to make sure duplicated item isn't added to array
        $args->offsetSet('1', 'test_2');
        $this->assertCount(1, $args);


        // check if item added to array
        $args->offsetSet('1', 'test3');
        $this->assertCount(1, $args);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::offsetExists
     */
    public function testOffsetExists()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $bool = $args->offsetExists(1);
        $this->assertTrue($bool);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::get
     */
    public function testGet()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $this->assertArrayHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::offsetGet
     */
    public function testOffsetGet()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $this->assertStringContainsString($args->offsetGet('test'), 'pass');
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::offsetUnset
     */
    public function testOffsetUnset()
    {
        $args = new ArgumentArray();
        $args['test'] = 'pass';
        $args->offsetUnset('test');
        $this->assertArrayNotHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::merge
     */
    public function testMerge()
    {
        $args = new ArgumentArray();
        $args->merge(['test' => 'pass']);
        $this->assertArrayHasKey('test', $args->get());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::current
     */
    public function testCurrent()
    {
        $args = new ArgumentArray();
        $args[] = 'test 1';
        $this->assertEquals('test 1', $args->current());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::next
     */
    public function testNext()
    {
        $args = new ArgumentArray();
        $args['a'] = 'a';
        $args['b'] = 'b';
        $args['c'] = 'c';
        foreach ($args as $key => $arg) {
            $this->assertEquals($key, $arg);
        }
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::key
     */
    public function testKey()
    {
        $args = new ArgumentArray();
        $args['a'] = 'test';
        $this->assertEquals('a', $args->key());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::valid
     */
    public function testValid()
    {
        $args = new ArgumentArray();
        $args[] = 'test';
        $this->assertEquals(true, $args->valid());
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\ArgumentArray::rewind
     */
    public function testRewind()
    {
        $args = new ArgumentArray();
        $args[] = 'test 1';
        $args[] = 'test 2';
        $args->next();
        $this->assertEquals(0, $args->rewind());
    }
}
