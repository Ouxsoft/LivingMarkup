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
 * Class Document
 *
 * Hyperlink DomDocument that is loaded from a well formatted LHTML5 document and returns a HTML5
 *
 * @package LivingMarkup
 */
class Document extends DomDocument
{
    public function __construct()
    {
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
     * Loads source, which is in LHTML5 format, as DomDocument
     *
     * A custom load page wrapper is required for server-side HTML5 entity support.
     * Using $this->loadHTMLFile will removes HTML5 entities, such as &copy;
     * due to the libxml not supporting HTML5
     *
     * @param string $source must be well formatted and feature a root element, e.g. <html>
     * @return bool
     */
    public function loadSource(string $source)
    {
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

        // adds HTML root element if one is not present
        if (!is_object($this->documentElement)) {
            return false;
        }

        $root_tag = $this->documentElement->tagName;
        if (strcasecmp($root_tag, 'html') !== 0) {
            $root_element = $this->createElement('html');
            $this->appendChild($root_element);
        }
        return true;
    }
}
