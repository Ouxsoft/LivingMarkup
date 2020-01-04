<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * <var name="username"/>
 */
namespace Pxp\DynamicElement;

class Variable extends DynamicElement
{

    public function format(string $format)
    {
        
        // set format function and parameters
        preg_match('/(?<function>\w+)\((?<parameters>[^)]+)/', $format, $matches);
        $function = $matches['function'];
        $parameters = explode(',', $matches['parameters']);
        
        // sanitize each parameter
        foreach ($parameters as &$parameter) {
            // TODO: lookup and replace variables
            $parameter = trim($parameter, '\'');
        }
        
        $value = $this->getVariable();

        return $this->$function($value, $parameters);
    }

    private function substr(string $string, array $parameters): string
    {
        return substr($string, $parameters[0], $parameters[1]);
    }

    private function str_replace(string $string, array $parameters): string
    {
        return str_replace($parameters[0], $parameters[1], $string);
    }

    private function getVariable($name){
        if(array_key_exists($name,$this->ancestors)){
            return $this->ancestors[$name];
        }
        return null;
    }
    public function onRender(): string
    {
        // get variable
        $variable = $this->getVariable($this->args['name']);

        if(is_null($variable)){
            return '<!-- Variable "' . $this->args['name'] . '" Not Found -->';
        }

        if (isset($this->format)) {
            return $this->format($this->name, $this->format);
        }

        return $variable;
    }
}