<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests\Unit;

use LivingMarkup\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{

    /**
     * @covers \LivingMarkup\Document::loadSource
     */
    public function testLoadSource()
    {
        // load without doctype
        $doc = new Document();
        $doc->loadSource('<html lang="en">Test</html>');
        $output = $doc->saveHTML();
        $output = $this->removeWhitespace($output);
        $this->assertStringContainsString($output, '<!DOCTYPE html><html lang="en">Test</html>');

        // load with doctype
        $doc = new Document();
        $doc->loadSource('<!DOCTYPE html>
<html lang="en">Test</html>');
        $output = $doc->saveHTML();
        $output = $this->removeWhitespace($output);
        $this->assertStringContainsString($output, '<!DOCTYPE html><html lang="en"><body><p>Test</p></body></html>');

        // add html root
        $doc = new Document();
        $doc->loadSource('Test');
        $output = $doc->saveHTML();
        $output = $this->removeWhitespace($output);
        $this->assertStringContainsString($output, '<!DOCTYPE html><html lang="en"><body><p>Test</p></body></html>');

        // test add html root element
        $doc = new Document();
        $doc->loadSource('<p>Test</p>');
        $output = $doc->saveHTML();
        $output = $this->removeWhitespace($output);
        $this->assertStringContainsString($output, '<!DOCTYPE html><html lang="en"><p>Test</p></html>');
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
     * @covers \LivingMarkup\Document::__construct
     */
    public function test__construct()
    {
        $doc = new Document();
        $this->assertIsObject($doc);
    }
}
