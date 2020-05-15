<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// set root directory
chdir(dirname(__DIR__,1));

require 'vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;

$path = 'public/assets/css/main.min.css';

try {
    $scss = new Compiler();
    $scss->setFormatter("ScssPhp\ScssPhp\Formatter\Compressed");

    // set root import path and add additional paths
    $scss->setImportPaths('assets/scss/');
    $scss->addImportPath('vendor/twbs/bootstrap/scss/');

    // compile
    $output = $scss->compile('@import "main.scss";');

    // save
    file_put_contents($path, $output);

} catch (\Exception $e) {
    syslog(LOG_ERR, 'Unable to compile SASS content');
}