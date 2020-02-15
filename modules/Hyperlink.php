<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules;

/**
 * Class Hyperlink
 *
 * Replaces <a> tag links on website
 *
 */
class Hyperlink extends \LivingMarkup\Module
{
    private $href;

    private $alt;

    /**
     * Returns an Hyperlink tag with HREF attribute similar to original DomElement
     *
     * TODO: look up href_id to allows for pages to be moved without updating link
     *
     * @return string
     */
    public function onRender()
    {
        $this->href = isset($this->args['href']) ? $this->args['href'] : '#';

        return "<a href=\"{$this->href}\">{$this->xml}</a>";
    }
}
