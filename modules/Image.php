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
    const IMAGE_SOURCE_DIR = '/assets/images/';
    const IMAGE_CACHE_DIR = '/cache/type/images/';

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

        // set dimensions
        $width = $this->getArgByName('width');
        $height = $this->getArgByName('height');
        $this->setDimensions($width, $height);

        // set offset
        $offset = $this->getArgByName('offset');
        $this->setOffset($offset);

        // set alt
        $alt = $this->getArgByName('alt');
        $this->setCacheURL($alt);
    }

    /**
     * Rendered output
     *
     * @return mixed|string
     */
    public function onRender()
    {
        // TODO: Consider multiple size screen using HTML images
        return <<<HTML
<img src="{$this->src}" alt="{$this->alt}" width="{$this->width}" height="{$this->height}"/>
HTML;
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
     * @param null $alt
     * @return string
     */
    public function setCacheURL($alt = NULL)
    {

        // use base cache directory
        $src = self::IMAGE_CACHE_DIR;

        if (empty($alt)) {
            $this->alt = 'decorative';
            $filename = 'decorative.jpg';
        } else {
            $this->alt = $alt;
            $filename = $alt . 'jpg';
        }

        $src .= Path::encode([
            'id' => $this->id,
            'dimension' => [
                $this->width,
                $this->height
            ],
            'offset' => [
                $this->offset['x'],
                $this->offset['y']
            ],
            'filename' => $filename
        ]);

        $this->src = $src;

        return true;
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