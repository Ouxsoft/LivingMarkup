<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup;

/**
 * Class Path
 *
 * @package LivingMarkup
 */
class Path
{

    /**
     * Decodes string of parameters to array
     *
     * @param string $string
     * @return array
     */
    public static function decode(string $string): array
    {
        $parts = explode('/', $string);
        $parameters = [];
        foreach ($parts as $key => $value) {
            if ($value == null) {
                continue;
            }
            if ($key % 2 == 0) {
                // if comma then is array
                if (strpos($value, ',') !== false) {
                    $value = explode(',', $value);
                }
                // if dimensions then is array
                if (preg_match('/([0-9]+x[0-9]+)/', $value)) {
                    $value = explode('x', $value);
                }
            }
            // set parameter
            $parameters[$key] = $value;
        }

        $parameters['name'] = end($parts);

        return $parameters;
    }

    /**
     * Encodes parameters provided
     *
     * @param array $parameters
     * @return string
     */
    public static function encode(array $parameters): string
    {
        $path = '';
        foreach ($parameters as $parameter => $value) {
            if ($parameter == 'filename') {
                $path .= $value;
                continue;
            }

            if (is_array($value)) {
                switch ($parameter) {
                    case 'dimension':
                        $glue = 'x';
                        break;
                    default:
                        $glue = ',';
                        break;
                }
                $value = implode($glue, $value);
            }

            $path .= $parameter . '/' . $value . '/';
        }

        $path = preg_replace('/^[\w#-]+$/', '', $path);
        $path = str_replace(' ', '-', $path);
        $path = strtolower($path);

        return $path;
    }
}
