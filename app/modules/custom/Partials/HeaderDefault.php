<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Custom\Partials;

use LivingMarkup\Module;

/**
 * Class HeaderDefault
 * @package LivingMarkup\Modules\Custom\Partials
 */
class HeaderDefault extends Module
{
    public function onRender()
    {
        return <<<HTML

        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/livingmarkup/icon/light-transparent-bg.png" width="24" class="d-inline-block align-top" alt=""/>
                LivingMarkup            
            </a>
        </nav>
HTML;
    }
}
