<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Component;

class Redacted extends Component
{
    public $char = '&#9608;';

    public function onRender(): string
    {
        $out = strip_tags($this->xml, '<p><div>');
        $count = strlen($out);
        $out = str_repeat($this->char, $count);
        return $out;
    }
}
