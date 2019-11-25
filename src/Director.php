<?php

namespace Pxp;

class Director
{
    public function build(Builder &$builder, $parameters) : object 
    {
        
        $builder->createObject($parameters);
        
        return $builder->getObject();
    }
}
