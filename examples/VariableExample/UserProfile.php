<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Component\Widgets;

use LivingMarkup\Component\Component;

/**
 * Class UserProfile
 *
 * @package LivingMarkup\Component\Widgets
 */
class UserProfile extends Component
{
    public $username = 'jane_doe';
    public $first_name = 'Jane';
    public $last_name = 'Doe';

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