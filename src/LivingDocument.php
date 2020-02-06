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

use DomDocument;

/**
 * Class LivingDocument
 *
 * A LHTML5 DomDocument
 *
 * @package LivingMarkup
 */
class LivingDocument extends DomDocument {

    function __construct(){
        parent::__construct();

        // suppress xml parse errors unless debugging
        libxml_use_internal_errors(true);

        // DomDocument format output option
        $this->formatOutput = true;

        // DomDocument object setting to preserve white space
        $this->preserveWhiteSpace = false;

        // DomDocument strict error checking setting
        $this->strictErrorChecking = false;

        // validate DOM on Parse
        $this->validateOnParse = false;

        // DomDocument encoding
        $this->encoding = 'UTF-8';
    }
    /**
     * Loads source as LHTML5 Dom Document
     *
     * Custom load page wrapper for server side HTML5 entity support
     * (cannot use $this->dom->loadHTMLFile as it removes HTML5 entities, such as &copy;)
    */
    function loadSource($source){
        // add DOCTYPE declaration
        $doctype = '<!DOCTYPE html [' . Entities::HTML5 . ']>'. PHP_EOL;

        // replace DOCTYPE if present
        $count = 1;
        str_ireplace('<!doctype html>', $doctype, $source, $count);
        if ($count == 0) {
            // add doctype if not present
            $source = $doctype . $source;
            // load as XML
            $this->loadXML($source);
        } else {
            // load as HTML
            $this->loadHTML($source);
        }
    }
}