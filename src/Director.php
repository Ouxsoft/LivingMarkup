<?php

namespace Pxp;

class Director
{

    // builder document
    public function build(Builder &$builder) : object 
    {
        
        $builder->createObject();
//        $builder->addHooks();
//        $builder->addElements();
//        $builder->addElements();

        return $builder->getObject();
    }
}
