<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement\Widgets;

use Pxp\DynamicElement\DynamicElement;

/**
 * Class UserProfile
 *
 * @package Pxp\DynamicElement\Widgets
 */
class GroupProfile extends DynamicElement
{
    public $group = 'Curators';
    public $first_name = 'Website';
    public $last_name = 'Curators';

    /**
     * @return mixed|string
     */
    public function onRender()
    {
        return '<div class="group_profile">' . $this->xml . '</div>';
    }
}