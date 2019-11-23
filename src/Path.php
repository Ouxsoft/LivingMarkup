<?php

namespace Pxp;

class Path {

    public static function decode($string){
        $parts = explode('/',$string);
        $parameters = [];
        foreach($parts as $key => $value){
            if($value == NULL) {
                continue;
            }
            if($key % 2 == 0){
                // if comma then array
                if(strpos($value,',') !== false){
                    $value = explode(',',$value);
                }
                // if dimensions then array
                if(preg_match('/([0-9]+x[0-9]+)/', $value)){
                    $value = explode('x',$value);
                }
                // set parameter
                $parameters[$parameter_key] = $value;
            } else {
                $parameter_key = $value;
            }
        }
        $parameters['name'] = $value;

        return $parameters;
    }

    public static function encode($parameters) {
        $path = '';
        foreach($parameters as $parameter => $value){

            if($parameter == 'filename'){
                $path .= $value;
                continue;
            }

            if( is_array($value) ){
                switch ($parameter){
                    case 'dimension':
                        $glue = 'x';
                        break;
                    default:
                        $glue = ',';
                        break;
                }
                $value = implode($glue,$value);
            }

            $path .= $parameter . '/' . $value . '/';
        }

        $path = preg_replace('/^[\w#-]+$/', '', $path);
        $path = str_replace(' ', '-', $path);
        $path = strtolower($path);

        return $path;    
    }
}