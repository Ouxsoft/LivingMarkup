<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Test\Builder;

use LivingMarkup\Builder\SearchIndexBuilder;
use LivingMarkup\Configuration;
use LivingMarkup\Engine;
use PHPUnit\Framework\TestCase;

class SearchIndexBuilderTest extends TestCase
{
    /**
     * @covers \LivingMarkup\Builder\SearchIndexBuilder::getObject
     */
    public function testGetObject()
    {
        $filepath = dirname(__DIR__, 2) . '/Resource/config/phpunit.yml';
        $config = new Configuration();
        $config->loadFile($filepath);
        $builder = new SearchIndexBuilder();
        $builder->createObject($config);
        $engine = $builder->getObject();
        $this->assertTrue(($engine instanceof Engine));
    }

    /**
     * @covers \LivingMarkup\Builder\SearchIndexBuilder::createObject
     */
    public function testCreateObject()
    {
        $filepath = dirname(__DIR__, 2) . '/Resource/config/phpunit.yml';
        $config = new Configuration();
        $config->loadFile($filepath);

        $builder = new SearchIndexBuilder();
        $builder->createObject($config);
        $engine = $builder->getObject();
        $this->assertTrue(($engine instanceof Engine));
    }
}
