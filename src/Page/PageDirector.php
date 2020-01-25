<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\Page;

use Pxp\Page\Builder\BuilderInterface;

/**
 * Class PageDirectorTest
 * @package Pxp\Page
 */
class PageDirector
{
    /**
     * Calls Builder using parameters supplied
     *
     * @param BuilderInterface $builder
     * @param $parameters
     * @return object
     */
    public function build(BuilderInterface &$builder, $parameters): object
    {
        $builder->createObject($parameters);

        return $builder->getObject();
    }
}
