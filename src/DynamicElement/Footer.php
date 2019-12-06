<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement;

class Footer extends DynamicElement
{
    public function getPageScripts()
    {
        // TODO: figure out how this works
    }
    
    public function onRender()
    {
        return <<<HTML
<footer>
    <hr/>
    <p>&copy; <var name="year"/> <var name="username"/></p>
</footer>
<script/>
HTML;
    }
}
