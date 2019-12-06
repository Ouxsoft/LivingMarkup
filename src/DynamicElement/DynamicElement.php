<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement;

/**
 * Interface ElementDefaultInterface
 * @package Pxp\DynamicElement
 */
interface DynamicElementDefaultInterface
{
    public function __construct($xml, $args);

    public function onRender();

    public function __toString();
}

/**
 * Class DynamicElement
 *
 * An abstract class extended to instantiate DynamicElements. During construction arguments and xml contained within
 * the Page's DomElement are passed to constructor.
 *
 * @package Pxp\DynamicElement
 */
abstract class DynamicElement implements DynamicElementDefaultInterface
{

    // placeholder id for PageBuilder::replaceElement()
    public $placeholder_id = 0;
    // id used to load args
    public $id = 0;
    // name of element
    public $name = 'unknown';
    // inner content on load
    public $xml;
    // args passed to during construction
    public $args = [];
    // tags used for filtering
    public $tags = [];
    // render in search result builder
    public $search_index = true;
    // maximum results of data pulled
    public $max_results = '240';

    /**
     * DynamicElement constructor
     *
     * @param $xml
     * @param $args
     */
    public function __construct($xml, $args)
    {
        // store elements inner xml
        $this->xml = $xml;
        // store args passed
        $this->args = $args;
        // assign object id to xml
        $this->placeholder_id = spl_object_hash($this);
    }

    /**
     * Call onRender if exists on echo / output
     *
     * @return mixed
     */
    public function __toString()
    {
        if (method_exists($this, 'onRender')) {
            return $this->onRender();
        }
    }

    /**
     * Abstract output method called by magic method
     *
     * The extending class must define this method
     *
     * @return mixed
     */
    abstract public function onRender();
}
