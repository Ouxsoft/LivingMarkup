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

use PHPUnit\Framework\TestCase;
use LivingMarkup\Builder\DynamicPageBuilder;
use LivingMarkup\Builder\StaticPageBuilder;
use LivingMarkup\Director;

// require examples Component
// TODO: automate
require __DIR__ . '/../examples/HelloWorldExample/HelloWorld.php';
require __DIR__ . '/../examples/BitwiseExample/Bitwise.php';
require __DIR__ . '/../examples/WebsiteSpoofingExample/MarkupInjection.php';
require __DIR__ . '/../examples/VariableExample/UserProfile.php';
require __DIR__ . '/../examples/VariableExample/GroupProfile.php';

define('LHTML_DATETIME', '2019-12-03 01:30:00');

final class ExamplesTest extends TestCase
{
    private $excluded_examples = [
        'HeadAndFooterExample',
        'IncludeHeaderExample',
        'ImgExample',
        'RedactExample'
    ];

    public function test()
    {

        // get example folders
        $example_folders = glob(__DIR__ . '/../examples/*', GLOB_ONLYDIR);

        // go through each folder
        foreach ($example_folders as $example_folder) {
            if ($this->isExcluded($example_folder)) {
                continue;
            }

            $parameters = [
                'filename' => $example_folder . DIRECTORY_SEPARATOR . 'input.html',
                'handlers' => [
                    '//h1' => 'LivingMarkup\Component\MarkupInjection',
                    '//widget' => 'LivingMarkup\Component\Widgets\{name}',
                    '//bitwise' => 'LivingMarkup\Component\Bitwise',
                    '//img' => 'LivingMarkup\Component\Img',
                    '//a' => 'LivingMarkup\Component\A',
                    '//var' => 'LivingMarkup\Component\Variable',
                    '//condition' => 'LivingMarkup\Component\Condition',
                    '//redact' => 'LivingMarkup\Component\Redact'
                ],
                'hooks' => [
                    'beforeLoad' => 'Executed before onLoad',
                    'onLoad' => 'Loads object data',
                    'afterLoad' => 'Executed after onLoad',
                    'beforeRender' => 'Executed before onLoad',
                    'onRender' => 'RETURN_CALL',
                    'afterRender' => 'Executed after onRender',
                ]
            ];

            // build dynamic page
            $director = new Director();
            $dynamic_builder = new DynamicPageBuilder();
            $page_results = (string)$director->build($dynamic_builder, $parameters);

            // build static page of the prebuild desired output
            $parameters['filename'] = $example_folder . DIRECTORY_SEPARATOR . 'output.html';
            $static_builder = new StaticPageBuilder();
            $page_check = (string)$director->build($static_builder, $parameters);

            // compare the two
            $this->assertEquals($page_check, $page_results);
        }
    }

    public function isExcluded($example_folder)
    {
        foreach ($this->excluded_examples as $exclude_example) {
            if ($this->endsWith($example_folder, basename($exclude_example))) {
                return true;
            }
        }
    }

    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
