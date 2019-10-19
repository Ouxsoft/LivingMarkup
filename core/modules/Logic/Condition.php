<?php

namespace Logic;

class Condition extends \Pxp\Element
{

        // ((profile_name == 222) and (profile_name !== 3))
        public function view(){

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
