<?php

namespace Pxp\Page;
use Pxp\Page\Builder\Builder;

class PageDirector
{
    public function build(Builder &$builder, $parameters) : object 
    {
        
        $builder->createObject($parameters);
        
        return $builder->getObject();
    }
}
