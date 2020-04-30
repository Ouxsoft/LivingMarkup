<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Custom\Examples;

use LivingMarkup\Module;

class MarkupInjection extends Module
{
    public function onRender()
    {
        if ($this->xml == 'Example Domain') {
            return '<h1 style="color:#F00">Spoofed :-)</h1>';
        }

        return '<h1>' . $this->xml . '</h1>';
    }
}
