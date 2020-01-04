<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Page\Builder;

use Pxp\Page\Page as Page;

/**
 * Class DynamicBuilder
 * @package Pxp\Page\Builder
 */
class DynamicBuilder extends Builder
{
    private $page;

    /**
     * Creates Page object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    public function createObject(array $parameters): ?bool
    {
        if (!isset($parameters['filename'])) {
            return false;
        }

        $this->page = new Page($parameters['filename']);

        // instantiate dynamic elements
        if (is_array($parameters['handlers'])) {
            foreach ($parameters['handlers'] as $xpath_expression => $class_name) {
                $this->page->instantiateElements($xpath_expression, $class_name);
            }
        }

        // build variable
        foreach($this->page->element_objects as $object){
            $parent_placeholder_ids = $this->page->getDomElementParents($object->placeholder_id);

            $parent_vars = [];
            foreach($parent_placeholder_ids as $parent_placeholder_id){

                $dynamic_element_vars = $this->page->getDynamicElementProperties($parent_placeholder_id);
                $parent_vars = array_merge($parent_vars, $dynamic_element_vars);
            }

            $object->parent_vars = $parent_vars;
        }


        // call hooks
        if (is_array($parameters['hooks'])) {
            foreach ($parameters['hooks'] as $name => $description) {
                $this->page->callHook($name, $description);
            }
        }

        return true;
    }

    /**
     * Gets Page object
     *
     * @return object|null
     */
    public function getObject(): ?object
    {
        return $this->page;
    }
}
