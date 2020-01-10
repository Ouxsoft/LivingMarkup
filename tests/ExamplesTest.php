<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Pxp\Tests;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PHPUnit\Framework\TestCase;
use Pxp\Page\Builder\DynamicBuilder;
use Pxp\Page\Builder\StaticBuilder;
use Pxp\Page\PageDirector;

// require examples DynamicElement
// TODO: automate
require __DIR__ . '/../examples/HelloWorldExample/HelloWorld.php';
require __DIR__ . '/../examples/BitwiseExample/Bitwise.php';
require __DIR__ . '/../examples/WebsiteSpoofingExample/MarkupInjection.php';
require __DIR__ . '/../examples/VariableExample/UserProfile.php';

define('PXP_DATETIME', '2019-12-03 01:30:00');

final class ExamplesTest extends TestCase
{
    private $excluded_examples = [
        'HeadAndFooterExample',
        'IncludeHeaderExample'
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
                    '//h1' => 'Pxp\DynamicElement\MarkupInjection',
                    '//widget' => 'Pxp\DynamicElement\Widgets\{name}',
                    '//bitwise' => 'Pxp\DynamicElement\Bitwise',
                    '//img' => 'Pxp\DynamicElement\Img',
                    '//a' => 'Pxp\DynamicElement\A',
                    '//var' => 'Pxp\DynamicElement\Variable',
                    '//condition' => 'Pxp\DynamicElement\Condition',
                    '//redacted' => 'Pxp\DynamicElement\Redacted'
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
            $director = new PageDirector();
            $dynamic_builder = new DynamicBuilder();
            $page_results = (string)$director->build($dynamic_builder, $parameters);

            // build static page of the prebuild desired output
            $parameters['filename'] = $example_folder . DIRECTORY_SEPARATOR . 'output.html';
            $static_builder = new StaticBuilder();
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

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}