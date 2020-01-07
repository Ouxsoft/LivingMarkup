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

/**
 * Class Variable
 * @package Pxp\DynamicElement
 */
class Variable extends DynamicElement
{

    /**
     * Parses and calls other specialized format methods
     *
     * @param string $format
     * @return mixed
     */
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

    /**
     * Sub string replace
     *
     * @param string $string
     * @param array $parameters
     * @return string
     */
    private function substr(string $string, array $parameters): string
    {
        return substr($string, $parameters[0], $parameters[1]);
    }

    /**
     * String replace
     *
     * @param string $string
     * @param array $parameters
     * @return string
     */
    private function str_replace(string $string, array $parameters): string
    {
        return str_replace($parameters[0], $parameters[1], $string);
    }

    /**
     * Get variable named
     *
     * @param $name
     * @return mixed|null
     */
    private function getVariable($name){
        if(array_key_exists($name,$this->ancestors)){
            return $this->ancestors[$name];
        }
        return null;
    }

    /**
     * on render call
     * @return string
     */
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