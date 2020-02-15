<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Examples\HeadAndFooter;

class Head extends \LivingMarkup\Module
{
    public function onRender()
    {
        return <<<HTML
<head lang="en">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<title>My Website</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
HTML;
    }
}
