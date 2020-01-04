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
class UserProfile extends DynamicElement
{
    public $username = 'jane_doe';
    public $first_name = 'jane';
    public $last_name = 'doe';

    /**
     * Prints Hello, World
     *
     * @return mixed|string
     */
    public function onRender()
    {
        return '<div class="user_profile">' . $this->xml . '</div>';
    }
}