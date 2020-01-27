<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Builder;

use Pxp\Page\Page as Page;

/**
 * Class DynamicPageBuilder
 * @package Pxp\Page\Builder
 */
class DynamicPageBuilder implements BuilderInterface
{
    public $page;
    /**
     * Creates Page object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    public function createObject(array $parameters): ?bool
    {
        $this->page = new Page($parameters);

        // instantiate dynamic elements
        if (is_array($parameters['handlers'])) {
            foreach ($parameters['handlers'] as $xpath_expression => $class_name) {
                $this->page->instantiateComponents($xpath_expression, $class_name);
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
