<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ouxsoft\LivingMarkup\Tests\Unit;

use Ouxsoft\LivingMarkup\Entities;
use PHPUnit\Framework\TestCase;

class EntitiesTest extends TestCase
{
    /**
     * @covers \Ouxsoft\LivingMarkup\Entities::fetchString
     */
    public function testFetchString()
    {
        $entities = new Entities();
        $entity_cache = $entities->fetchString();
        $this->assertStringContainsString('<!ENTITY', $entity_cache);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Entities::get
     */
    public function testGet()
    {
        $entities = new Entities();
        $cache_results = $entities->get();
        $this->assertStringContainsString('<!ENTITY', $cache_results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Entities::fetchArray
     * @codeCoverageIgnore
     */
    public function testFetchArray()
    {
        $entities = new Entities();
        $cache_results = $entities->fetchArray();
        $this->assertIsArray($cache_results);
    }

    /**
     * @covers \Ouxsoft\LivingMarkup\Entities::getURL
     */
    public function testGetURL()
    {
        $entities = new Entities();
        $url = $entities->getURL();
        $is_url = (filter_var($url, FILTER_VALIDATE_URL) === false) ? false : true;
        $this->assertTrue($is_url);
    }
}
