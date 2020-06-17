<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test;

use LivingMarkup\ArgumentArray;
use PHPUnit\Framework\TestCase;

class ArgumentArrayTest extends TestCase
{

    /**
     * @covers \LivingMarkup\ArgumentArray::offsetSet
     */
    public function testOffsetSet()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $this->assertCount(1, $args);
    }

    /**
     * @covers \LivingMarkup\ArgumentArray::offsetExists
     */
    public function testOffsetExists()
    {
        $args = new ArgumentArray();
        $args->offsetSet('1', 'test');
        $bool = $args->offsetExists(1);
        $this->assertTrue($bool);
    }

    /**
     * @covers \LivingMarkup\ArgumentArray::get
     */
/*    public function testGet()
    {

    }
*/
    /**
     * @covers \LivingMarkup\ArgumentArray::offsetGet
     */
  /*  public function testOffsetGet()
    {

    }
*/
    /**
     * @covers \LivingMarkup\ArgumentArray::offsetUnset
     */
    /*
    public function testOffsetUnset()
    {

    }
*/
    /**
     * @covers \LivingMarkup\ArgumentArray::merge
     */
  /*  public function testMerge()
    {

    }
  */
}
