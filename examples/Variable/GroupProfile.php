<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Examples\Variable;

/**
 * Class UserProfile
 *
 * @package LivingMarkup\Modules\Widgets
 */
class GroupProfile extends \LivingMarkup\Module
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
