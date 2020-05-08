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

/**
 * Class UserProfile
 *
 * @package LivingMarkup\Modules\Widgets
 */
class UserProfile extends Module
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
