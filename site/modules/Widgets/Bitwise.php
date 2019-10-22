<?php

namespace Widgets;

/*
<widget name="Bitwise">
    <arg name="number">2</arg>
    <arg name="count">6</arg>
    <arg name="operator">^</arg>
</widget>
*/

class Bitwise extends \Pxp\Element
{
	public function view(){

        $x = $this->args['number'];
        $count = $this->args['count'];
        $operator = $this->args['operator']; 

        $operators = ['>>'.'<<','&','~','|','^'];

        // only accept valid operator
        if( ! in_array($operator, $operators) ){
            return '<p>Bitwise operator invalid.</p>';
        }

        $out = '<ul class="bitwise">';
        for($x; $x <= $count; $x++){
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

        return $out;    
	}
}