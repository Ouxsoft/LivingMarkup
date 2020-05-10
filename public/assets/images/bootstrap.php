<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// turn off LHTML5 Autoloader
define('LHTML_OFF', 0);

require dirname(__DIR__,3) . '/vendor/autoload.php';

use LivingMarkup\Image;
use LivingMarkup\Path;

$request = array_key_exists('q', $_GET) ? $_GET['q'] : '';

$image = new Image();
$image->loadByURL($request);
$image->output();