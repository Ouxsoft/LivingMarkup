<?php

namespace \Pxp\DynamicElement;

class Condition extends DynamicElement
{

        // ((profile_name == 222) and (profile_name !== 3))
        public function onRender(){

                $variable['signed_in'] = TRUE;

                if ( ! isset($this->args['@attributes']['toggle']) ) {
                        return '';
                }

                // get name of condition toggle variable
                $toggle_name = $this->args['@attributes']['toggle'];

                // check if variable set in processor
                if( ! isset($variable[$toggle_name]) ){
                        return '';
                }
                
                // return inner content
                if( $variable[$toggle_name]  == TRUE ){
                        return $this->element;
                }

                return '';
	}
}
