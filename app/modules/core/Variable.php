<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules\Core;

use LivingMarkup\Module;

/**
 * Class Variable
 * @package LivingMarkup\Modules
 */
class Variable extends Module
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

        if (! method_exists($this, $function)) {
            return false;
        }

        // call specified function
        switch ($function) {
            case 'substr':
                return $this->substr($value, $parameters);
                break;
            case 'str_replace':
                return $this->str_replace($value, $parameters);
                break;
        }

        return false;
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
     * @param string $name
     * @param string $tag
     * @return mixed|null
     */
    private function getVariable(string $name, ?string $tag = '*') : ?string
    {
        foreach ($this->ancestors as $ancestor) {
            if (array_key_exists($name, $ancestor['properties']) && (($tag == '*') || ($tag == $ancestor['tag']))) {
                return $ancestor['properties'][$name];
            }
        }
        return null;
    }

    /**
     * on render call
     *
     * @return string
     */
    public function onRender(): string
    {
        $name = $this->getArgByName('name') ?? '';
        $tag = $this->getArgByName('tag') ?? '*';

        // get variable
        $variable = $this->getVariable($name, $tag);

        if ($variable===null) {
            return '<!-- Variable "' . $this->getArgByName('name') . '" Not Found -->';
        }

        if (isset($this->format)) {
            return $this->format($this->name, $this->format);
        }

        $variable = htmlentities($variable, ENT_QUOTES);

        return $variable;
    }
}
