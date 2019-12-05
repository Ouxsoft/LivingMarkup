<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace \Pxp\DynamicElement;

/**
 * Class A
 *
 * Replaces <a> tag links on website
 *
 */
class A extends DynamicElement
{

    private $href;

    private $alt;

    /**
     * Returns an A tag with HREF attribute similar to original DomElement
     *
     * TODO: look up href_id to allows for pages to be moved without updating link
     *
     * @return string
     */
    public function onRender()
    {

        $this->href = isset($this->args['href']) ? $this->args['href'] : '#';
        $attribute_href = ' href="' . $this->href . '"';

        // if alt tag missing add decorative alt
        $this->alt = isset($this->args['alt']) ? $this->args['alt'] : 'decorative';
        $attribute_alt = ' alt="' . $this->alt . '"';

        return <<<HTML
        <a {$attribute_href}{$attribute_alt}>{$this->element}</a>
HTML;
    }
}
