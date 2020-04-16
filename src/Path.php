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
        $filepath = '';
        $parts = explode('/', $string);
        $parameters = [];
        $previous_key = '';
        foreach ($parts as $value) {
            if ($value == null) {
                continue;
            }

            // start by building out filepath
            if(is_dir(dirname(__DIR__, 1) . $filepath . '/' . $value)){
                $filepath .= '/' . $value;
                continue;
            }

            switch ($previous_key) {
                case 'dimension':
                    // if dimensions then is array
                    if (preg_match('/([0-9]+x[0-9]+)/', $value)) {
                        list($width, $height) = explode('x', $value);
                        $parameters['width'] = $width;
                        $parameters['height'] = $height;
                    }
                    break;
                case 'offset':
                    // if comma then is array
                    if (strpos($value, ',') !== false) {
                        list($x, $y) = explode(',', $value);
                        $parameters['offset_x'] = $x;
                        $parameters['offset_y'] = $y;
                    }
                    break;
                default:
                    break;
            }

            $previous_key = $value;

        }

        $parameters['filename'] = $filepath . '/' . end($parts);

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
