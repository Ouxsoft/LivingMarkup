<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Tests;

use Exception as ExceptionAlias;
use PHPUnit\Framework\TestCase;

use LivingMarkup\Configuration;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Builder\StaticPageBuilder;
use LivingMarkup\Engine;
use LivingMarkup\Kernel;

// require examples Module
// TODO: automate
/*

require __DIR__ . '/../examples/HelloWorld/HelloWorld.php';
require __DIR__ . '/../examples/Bitwise/Bitwise.php';
require __DIR__ . '/../examples/WebsiteSpoofing/MarkupInjection.php';
require __DIR__ . '/../examples/Variable/UserProfile.php';
require __DIR__ . '/../examples/Variable/GroupProfile.php';
*/

define('LHTML_DATETIME', '2019-12-03 01:30:00');

final class ExamplesTest extends TestCase
{
    public function exampleDataProvider() : array
    {
        return [
            ['DynamicPage'],
            //['IfStatement'],
        ];
    }

    /**
     * @param string $example_name
     * @dataProvider exampleDataProvider
     */
    public function testBuildMatchesOutput(string $example_name)
    {

        // get example folders
        $example_folder = 'public/help/examples/' . $example_name . DIRECTORY_SEPARATOR;

        // get build
        $build_command = 'php -d include_path=. ' . $example_folder . 'input.php';
        $build_results = (string) shell_exec($build_command);

        $this->assertStringMatchesFormatFile($example_folder . 'output.html',  $build_results);
    }
}
