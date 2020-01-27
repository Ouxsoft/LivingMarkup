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

/**
 * Interface ElementDefaultInterface
 * @package LivingMarkup\Component
 */
interface ComponentDefaultInterface
{
    public function __construct($args);

    public function onRender();

    public function __toString();

    public function __invoke(string $method): bool;
}

/**
 * Class Component
 *
 * An abstract class extended to instantiate Components. During construction arguments and xml contained within
 * the Page's DomElement are passed to constructor.
 *
 * @package LivingMarkup\Component
 */
abstract class Component implements ComponentDefaultInterface
{

    // id used to reference object
    public $component_id = 0;
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
     * Component constructor
     *
     * @param $args
     */
    final public function __construct($args)
    {
        // store args passed
        $this->args = $args;
        // assign object id to xml
        $this->component_id = spl_object_hash($this);
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
