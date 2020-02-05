<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Component;

class Redact extends Component
{
    public $char = '&#9608;';

    // TODO: same sort of class would be useful for a search / highlighter function.

    /**
     * Renders with chars not between tag replaced with $char
     *
     * a black and white list of tags must consider redact element may be between tags
     *
     * @return string
     */
    public function onRender(): string
    {
        return preg_replace("/<[^>]+>(*SKIP)(*F)|./", $this->char, $this->xml);
    }
}
