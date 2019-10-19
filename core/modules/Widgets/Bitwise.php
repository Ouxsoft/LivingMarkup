<?php

namespace Widgets;

/*
    <widget name="Bitwise">
        <arg name="count">5</arg>
        <x>1</x>
        <operator>>></operator>
    </widget>
*/

class Bitwise extends \Pxp\Element
{
	public function view(){
        //return \print_r($GLOBALS, true);

        //return print_r(get_loaded_extensions());
        $x = 2; //$this->args['x'];
        $count = 3; //$this->args['count'];

        $out = '';

        // '>>'.'<<','&',
        $bitwise_operators = array('~','|','^');

        foreach($bitwise_operators as $key => $operator){
            $out .= $operator ? '' : $operator . PHP_EOL;
            $out .= '<ul>';
            for($x = 0; $x <= $count; $x++){
                $out .= '<li>';
                switch($operator){
                    case '>>':
                        // move over right amount
                        $out .= $x . ' >> 1 is ' . decbin ($x >> 1) . ' is ' . ($x >> 1);
                        break;
                    case '<<':
                        // move over left amount
                        $out .= $x . ' << 1 is ' . decbin ($x << 1) . ' is ' . ($x << 1);
                        break;
                    case '&':
                        // The & operator compares each binary digit of two integers and returns a new integer, with a 1 wherever both numbers had a 1 and a 0 anywhere else. 
                        $out .= $x . ' & 1 is ' . decbin ($x & 1) . ' is ' . ($x & 1);
                        break;
                    case '|':
                        // The | operator compares each binary digit across two integers and gives back a 1 if either of them are 1. 
                        $out .= $x . ' | 1 is ' . decbin ($x | 1) . ' is ' . ($x | 1);
                        break;
                    case '^':
                        //  If one or the other but not both is a 1, it will insert a 1 in to the result, otherwise it will insert a 0.
                        $out .= $x . ' ^ 1 is ' . decbin ($x ^ 1) . ' is ' . ($x ^ 1);
                        break;
                    case '~':
                        //  If one or the other but not both is a 1, it will insert a 1 in to the result, otherwise it will insert a 0.
                        $out .= '~' . $x . ' is ' . decbin (~$x) . ' is ' . (~$x);
                        break;

                    default:
                        $out .= $x . ' in binary is ' . decbin ($x);
                }
                $out .= '</li>' . PHP_EOL;
            }
            $out .= '</ul>' . PHP_EOL;
    
        }

        return $out;    
	}
}