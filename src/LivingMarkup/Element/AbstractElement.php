<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup\Element;

use LivingMarkup\ArgumentArray;


/**
 * Class Element
 *
 * An abstract class extended to instantiate Elements. During construction arguments and xml contained within
 * the Page's DomElement are passed to constructor.
 *
 * @package LivingMarkup\Element
 */
abstract class AbstractElement
{

    // id used to reference object
    public $element_id = 0;
    // id used to load args
    public $id = 0;
    // name of element
    public $name = 'unknown';
    // args passed to during construction
    public $args = [];
    // tags used for filtering
    public $tags = [];
    // render in search result builder
    public $search_index = true;
    // maximum results of data pulled
    public $max_results = '240';
    // ancestor public variable updated live
    public $ancestors = [];
    // inner content updated live
    public $xml = '';

    /**
     * Element constructor
     *
     * @param $args
     */
    final public function __construct(ArgumentArray $args = null)
    {

        // set object id
        $this->element_id = spl_object_hash($this);

        // store args passed
        if ($args === null) {
            $args = new ArgumentArray();
        }

        $this->args = $args;
    }

    /**
     * Call onRender if exists on echo / output
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->onRender();
    }

    /**
     * Gets the ID of the Element, useful for ElementPool
     *
     * @return int|string
     */
    public function getId() : string
    {
        return $this->element_id;
    }

    /**
     * Get arg by name
     *
     * @param $name
     * @return mixed|null
     */
    public function getArgByName(string $name)
    {
        return $this->args[$name];
    }

    /**
     * Get all args
     *
     * @return ArgumentArray
     */
    public function getArgs() : ArgumentArray
    {
        return $this->args;
    }

    /**
     * Get innerText
     * @return string|null
     */
    public function innerText() : ? string
    {
        return $this->xml;
    }

    /**
     * Abstract output method called by magic method
     * The extending class must define this method
     *
     * @return mixed
     */
    abstract public function onRender();

    /**
     * Invoke wrapper call to method if exists
     *
     * @param string $method
     * @return bool
     */
    final public function __invoke(string $method): bool
    {
        // if method does not exist, return
        if (!method_exists($this, $method)) {
            return false;
        }

        // call element method
        call_user_func([
            $this,
            $method
        ]);

        return true;
    }
}
