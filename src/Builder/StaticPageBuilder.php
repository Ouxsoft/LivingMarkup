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
 * Class StaticPageBuilder
 * @package LivingMarkup\Page\Builder
 */
class StaticPageBuilder implements BuilderInterface
{
    private $engine;

    /**
     * Creates Page object using parameters supplied
     *
     * @param $parameters
     * @return bool|null
     */
    public function createObject(array $parameters): ?bool
    {
        // determine source
        if (isset($parameters['filename'])) {
            $source = file_get_contents($parameters['filename']);
        } elseif (isset($parameters['markup'])) {
            $source = $parameters['markup'];
        } else {
            $source = '';
        }

        // create engine pass source
        $this->engine = new Engine($source);

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
