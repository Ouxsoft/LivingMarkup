<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <contact@mrheroux.com>
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

    // TODO: these should be scoped with the ob buffer
    private $variables = [
        'username' => 'Jane Doe',
        'location' => 'Lost In rome',
        'page_title' => 'Home',
        'year' => '2019'
    ];

    private $format;

    private $value;

    public function getValue()
    {
        return $this->variables[$this->args['name']];
    }

    public function format(string $variable, string $format)
    {
        
        // set format function and parameters
        preg_match('/(?<function>\w+)\((?<parameters>[^)]+)/', $format, $matches);
        $function = $matches['function'];
        $parameters = explode(',', $matches['parameters']);
        
        // santize each parameter
        foreach ($parameters as &$parameter) {
            // TODO: lookup and replace variables
            $parameter = trim($parameter, '\'');
        }
        
        $value = $this->getValue();
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

    public function onRender(): string
    {
        if (isset($this->format)) {
            return $this->format($this->name, $this->format);
        }
        
        if (isset($this->name)) {
            return $this->getValue();
        }
        
        return '';
    }
}
