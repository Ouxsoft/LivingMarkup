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
 * Class Configuration
 * @package LivingMarkup
 */
class Configuration {

    const LOCAL_FILENAME = 'config.yml';
    const DIST_FILENAME = 'config.dist.yml';

    private function parse($path){
        $config = yaml_parse_file($path);

        if (empty($config)) {
            return false;
        }

        return $config;
    }

    /**
     * @param string $filename
     * @return bool|mixed
     */
    public function load($filename = NULL)
    {
        // try to load config using filename if parameter set
        if($filename!==NULL){
            return self::parse($filename);
        }

        // try to load local config
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . self::LOCAL_FILENAME;
        if(file_exists($path)){
            return self::parse($path);
        }

        // try to load dist config
        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . self::DIST_FILENAME;
        if(file_exists($path)){
            return self::parse($path);
        }

        return false;

    }
}