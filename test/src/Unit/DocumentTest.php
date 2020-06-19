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

use LivingMarkup\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{


    public function testLoadSource()
    {
        // load without doctype
        $doc = new Document();
        $doc->loadSource('<html>Test</html>');
        $output = $doc->saveHTML();
        $this->assertStringContainsString($output, '<!DOCTYPE html>
<html>Test</html>
');

        // load with doctype
        $doc = new Document();
        $doc->loadSource('<!DOCTYPE html>
<html>Test</html>');
        $output = $doc->saveHTML();
        $this->assertStringContainsString($output, '<!DOCTYPE html>
<html><body><p>Test</p></body></html>
');

        // add html root
        $doc = new Document();
        $doc->loadSource('Test');
        $output = $doc->saveHTML();
        $this->assertStringContainsString($output, '<!DOCTYPE html>
<html><body><p>Test</p></body></html>
');

        // test add html root element
        $doc = new Document();
        $doc->loadSource('<p>Test</p>');
        $output = $doc->saveHTML();
        $this->assertStringContainsString($output, '<!DOCTYPE html>
<html><body><p>Test</p></body></html>
');

    }

    public function test__construct()
    {

    }
}
