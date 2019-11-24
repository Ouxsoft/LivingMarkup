<?php

namespace Pxp;

class Director
{
    public function build(Builder &$builder) : object 
    {
        
        $builder->createObject();
        
        return $builder->getObject();
    }
}
