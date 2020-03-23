<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LivingMarkup\Modules;

use LivingMarkup\Path;

class Image extends \LivingMarkup\Module
{
    // configurations
    const IMAGE_SOURCE_DIR = '/assets/images/';
    const IMAGE_CACHE_DIR = '/cache/type/images/';
    const NUMBER_OF_STEPS = 4; // used to determine granularity of image sizes
    const MAX_WIDTH = 200; // the largest image width supported
    const MIN_WIDTH = 0; // the smallest image width supported
    const MAX_HEIGHT = 200; // max largest image height supported
    const MIN_HEIGHT = 0; // the smallest image height supported

    // output defaults
    private $src = 'blank.jpg';
    private $alt = 'decorative';
    private $author = 'Unknown';
    private $width = NULL;
    private $height = NULL;
    private $offset = [
        'x' => 0,
        'y' => 0
    ];

    // source
    private $source_width;
    private $source_height;
    private $source_type;
    private $source_attr;

    /**
     * Executed during load
     */
    public function onLoad(){

        // load source file info
        $src = $this->getArgByName('src');
        $this->fetchSourceInfo($src);
        $this->fetchSourceInfo($src);

        // set dimensions
        $width = $this->getArgByName('width');
        $height = $this->getArgByName('height');
        $this->setDimensions($width, $height);

        // set offset
        $offset = $this->getArgByName('offset');
        $this->setOffset($offset);

        // set alt
        $alt = $this->getArgByName('alt');
        $this->setAlt($alt);

        // set src
        $this->src = $this->getArgByName('src');
    }

    /**
     * Get sizes
     *
     * @param $width
     * @param $height
     * @return array
     */
    private function getSizes($width, $height){
        // set max and min image height
        $max_width = ($width < self::MAX_WIDTH) ? $width : self::MAX_WIDTH;
        $max_height = ($height < self::MAX_HEIGHT) ? $height : self::MAX_HEIGHT;
        $min_width = ($width > self::MIN_WIDTH) ? $width : self::MIN_WIDTH;
        $min_height = ($height > self::MIN_HEIGHT) ? $height : self::MIN_HEIGHT;

        // determine width increment
        $width_increment = ($max_width - $min_width) / self::NUMBER_OF_STEPS;
        $width_increment = round($width_increment);

        // height width increment
        $height_increment = ($max_height - $min_width) / self::NUMBER_OF_STEPS;
        $height_increment = round($height_increment);

        // figure out possible sizes
        $current_width = $min_width;
        $current_height = $min_height;
        $sizes = [];
        do {
            // add current sizes to array
            $sizes[] = [
                'height' => $current_height,
                'width' => $current_width
            ];

            // increment width
            $current_width += $width_increment;
            $current_width = ($current_width < $max_width) ? $current_width : $max_width;

            // increment height
            $current_height += $height_increment;
            $current_height = ($current_height < $max_height) ? $current_height : $max_height;

        } while ( ($current_width < $max_width) && ($current_height < $max_height) );

        return $sizes;
    }

    /**
     * Rendered output
     *
     * @return mixed|string
     */
    public function onRender()
    {

        $width = $this->width;
        $height = $this->height;

        $out = '<img';

        $sizes = $this->getSizes($width, $height);

        // srcset
        $last_key = array_key_last($sizes);
        $out .= ' srcset="';
        foreach($sizes as $key => $size){
            $out .= $this->getCacheURL($this->src, $size['width'], $size['height']) .
                ' ' . $size['width'] . 'w' . (($key!==$last_key) ?  ',' : '');
        }
        $out .= '"';

        // sizes
        $sizes = [
            '(max-width: 600px) 480px',
            '800px'
        ];
        $out .= ' sizes="';
        foreach($sizes as $key => $size){
            $out .= $size . (($key!==$last_key) ?  ',' : '');
        }
        $out .= '"';

        // src and alt
        $out .= ' src="' . $this->getCacheURL($this->src) . '" alt="' . $this->alt . '"/>';

        return $out;
    }

    public function fetchSourceInfo($source)
    {

        // TODO: add traversing prevention
        $filepath = __DIR__ . '/..' . self::IMAGE_SOURCE_DIR . $source;

        // get dimensions from original image file
        [$this->source_width, $this->source_height, $this->source_type, $this->source_attr] = getimagesize($filepath);

        return true;
    }

    /**
     * Gets an URL for where image cache is or will stored
     *
     * @param null $src
     * @param null $width
     * @param null $height
     * @return string
     */
    public function getCacheURL($src = NULL, $width = NULL, $height = NULL)
    {
        // set width and height if not provided
        $width = ($width === NULL) ? $width : $this->width;
        $height = ($height === NULL) ? $height : $this->height;

        // start with base filename
        $filename = basename($src);

        // use base cache directory
        $path = self::IMAGE_CACHE_DIR;

        // add parametrized cache path
        $path .= Path::encode([
            'id' => $this->id,
            'dimension' => [
                $width,
                $height
            ],
            'offset' => [
                $this->offset['x'],
                $this->offset['y']
            ],
            'filename' => $filename
        ]);

        return $path;
    }

    /**
     * Set alt attribute
     *
     * @param $alt
     */
    public function setAlt($alt){
        if (empty($alt)) {
            $this->alt = 'decorative';
            return;
        }

        $this->alt = $alt;
    }

    /**
     * Set offset from 10,-10
     *
     * @param $offset
     */
    public function setOffset($offset){
        if (isset($offset)) {
            list($this->offset['x'], $this->offset['y']) = explode(',', $offset);
        }
    }

    /**
     * Set dimension (width x height) of output
     *
     * @param $width
     * @param $height
     * @return bool
     */
    public function setDimensions($width, $height){

        // if width provided as attribute set
        if (is_numeric($width)) {
            $this->width = (int) $width;
        }

        // if height provided as attribute set
        if (is_numeric($height)) {
            $this->height = (int) $height;
        }

        // return as both height and width are set
        if(($this->width!==NULL) && ($this->height!==NULL) ){
            return true;
        }

        // determine height if height provided based on original image ratio
        if(($this->width!==NULL) && ($this->height===NULL)){
            $this->height = round($this->width * ($this->source_height/$this->source_width));
            return true;
        }

        // determine width if height provided based on original image ratio
        if(($this->width===NULL) && ($this->height!==NULL)){
            $this->width = round($this->height * ($this->source_width/$this->source_height));
            return true;
        }

        // nether width or height provided use original image size
        $this->width = $this->source_width;
        $this->height = $this->source_height;
        return true;
    }

    /**
     * var_dump return
     *
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'src' => $this->src,
            'alt' => $this->alt,
            'width' => $this->width,
            'height' => $this->height,
            'offset' => [
                'x' => $this->offset['x'],
                'y' => $this->offset['y']
            ]
        ];
    }

    /*
    // id / X-Y / X-Y . jpg
    public function onSubmit()
    {
    }

    public function focalPointForm()
    {
        return <<<HTML
		<form method="post">
			<input type="image" name="focal_point" src="/assets/images/livingMarkup/logo/original.jpg"/>
		</form>
HTML;
    }

    // cache/image/{id}/
    public function getInfo($filename)
    {
        // {width}x{height}(+/-){offset_x}(+/-){offset_y}.jpg
        sscanf($filename, "%dx%d%d", $width, $height, $offset_x, $offset_y);

        return [
            'width' => $width,
            'height' => $height,
            'offset' => [
                'x' => $offset_x,
                'y' => $offset_y
            ]
        ];
    }
    */
}