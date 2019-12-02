<?php

namespace Pxp\Page;
use Pxp\Page\Builder\Builder;

/**
 * Class PageDirector
 * @package Pxp\Page
 */
class PageDirector
{
    /**
     * Calls Builder using parameters supplied
     *
     * @param Builder $builder
     * @param $parameters
     * @return object
     */
    public function build(Builder &$builder, $parameters) : object
    {
        
        $builder->createObject($parameters);
        
        return $builder->getObject();
    }
}
