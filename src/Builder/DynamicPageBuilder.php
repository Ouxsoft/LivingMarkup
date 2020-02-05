<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Builder;

use LivingMarkup\Engine as Engine;

/**
 * Class DynamicPageBuilder
 * @package LivingMarkup\Page\Builder
 */
class DynamicPageBuilder implements BuilderInterface
{
    public $engine;

    /**
     * Creates Page object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    public function createObject(array $parameters): ?bool
    {
        // set source
        if (array_key_exists('filename', $parameters)) {
            $source = file_get_contents($parameters['filename']);
        } elseif (array_key_exists('markup', $parameters))  {
            $source = $parameters['markup'];
        } else {
            $source = '';
        }

        // create engine pass source
        $this->engine = new Engine($source);

        // instantiate dynamic elements
        if (is_array($parameters['handlers'])) {
            foreach ($parameters['handlers'] as $xpath_expression => $class_name) {
                $this->engine->instantiateComponents($xpath_expression, $class_name);
            }
        }

        // call hooks
        if (is_array($parameters['hooks'])) {
            foreach ($parameters['hooks'] as $name => $description) {
                $this->engine->callHook($name, $description);
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
        return $this->engine;
    }
}