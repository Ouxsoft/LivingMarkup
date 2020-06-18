<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test\Exception;

use LivingMarkup\Exception\Exception;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Exception\Exception::__construct
     * @covers \LivingMarkup\Exception\Exception::getLog
     */
    public function test__construct()
    {
        $exception = new Exception('test');
        $this->assertIsString($exception->getLog());
    }
}
