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

use LivingMarkup\Page\Page as Page;

/**
 * Class StaticPageBuilder
 * @package LivingMarkup\Page\Builder
 */
class StaticPageBuilder implements BuilderInterface
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

        $this->page = new Page($parameters);

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
