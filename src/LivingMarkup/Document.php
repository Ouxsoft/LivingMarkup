<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup;

use DomDocument;
use LivingMarkup\Exception\Exception;

/**
 * Class Document
 * Hyperlink DomDocument that is loaded from a well formatted LHTML document and returns a HTML5
 *
 * @package LivingMarkup
 */
class Document extends DomDocument
{
    /**
     * Document constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // suppress xml parse errors unless debugging
        libxml_use_internal_errors(true);

        // DomDocument format output option
        $this->formatOutput = true;

        // DomDocument object setting to preserve white space
        $this->preserveWhiteSpace = true;

        // DomDocument strict error checking setting
        $this->strictErrorChecking = false;

        // validate DOM on Parse
        $this->validateOnParse = false;

        // DomDocument encoding
        $this->encoding = 'UTF-8';
    }

    /**
     * Loads source, which is in LHTML format, as DomDocument
     *
     * A custom load page wrapper is required for server-side HTML5 entity support.
     * Using $this->loadHTMLFile will removes HTML5 entities, such as &copy;
     * due to the libxml not supporting HTML5
     *
     * @param string $source must be well formatted and feature a root element, e.g. <html>
     * @return bool
     */
    public function loadSource(string $source) : bool
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
            // TODO: figure out whether to throw
            // throw new Exception('Invalid LHTML document provided');
        }

        // add html root element if missing
        $root_tag = $this->documentElement->tagName;
        if (strcasecmp($root_tag, 'html') !== 0) {
            // create a new DomDocument, add source to it, and append to root document with html root
            $source_dom = new DOMDocument();
            $source_dom->loadXML($source);
            $this->loadSource('<html></html>');
            $this->documentElement->appendChild(
                $this->importNode($source_dom->documentElement, true)
            );
        }

        return true;
    }
}
