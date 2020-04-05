<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

/**
 * Interface ElementDefaultInterface
 * @package LivingMarkup\Module
 */
interface ModuleDefaultInterface
{
    public function __construct(array $args);

    public function onRender();

    public function __toString();

    public function __invoke(string $method): bool;
}

/**
 * Class Module
 *
 * An abstract class extended to instantiate Modules. During construction arguments and xml contained within
 * the Page's DomElement are passed to constructor.
 *
 * @package LivingMarkup\Module
 */
abstract class Module implements ModuleDefaultInterface
{

    // id used to reference object
    public $module_id = 0;
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
     * Module constructor
     *
     * @param $args
     */
    final public function __construct(array $args = [])
    {
        // store args passed
        $this->args = $args;

        // set object id
        $this->module_id = spl_object_hash($this);
    }

    /**
     * Call onRender if exists on echo / output
     *
     * @return string
     */
    public function __toString() : string
    {
        if (method_exists($this, 'onRender')) {
            return $this->onRender();
        }
        return '';
    }

    /**
     * Gets the ID of the Module, useful for ModulePool
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->module_id;
    }

    /**
     * Get Arg by Name
     *
     * @param $name
     * @return mixed|null
     */
    public function getArgByName($name)
    {
        return array_key_exists($name, $this->args) ? $this->args[$name] : null;
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
