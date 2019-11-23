<?php

namespace Pxp;

class Director
{

    // builder document
    public function build(Builder &$builder) : object 
    {
        
        $builder->createPage();
//        $builder->addHooks();
//        $builder->addHandlers();
//        $builder->addElements();

        return $builder->getPage();
    }
}
