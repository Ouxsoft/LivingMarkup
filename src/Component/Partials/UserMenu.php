<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Component\Partials;

use LivingMarkup\Component\Component;

class UserMenu extends Component
{
    public function onRender()
    {
        return <<<HTML
<!-- User Menu -->
<div>
<condition toggle="signed_in">
    <h2>Welcome, <var name="username"/></h2>
    <p>You're signed in right now</p>
</condition>
<condition toggle="signed_out">
    <a href="1000" alt="Test">Sign in</a>
</condition>
</div>
HTML;
    }
}
