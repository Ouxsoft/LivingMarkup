<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
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
                $this->page->instantiateElement($xpath_expression, $class_name);
            }
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