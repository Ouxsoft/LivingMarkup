<?php

namespace LivingMarkup;

class ImageResize {

    const JPEG = 1;
    const JPG = 1;
    const PNG = 2;

    private $filename;
    private $width;
    private $height;
    private $focal_point_x;
    private $focal_point_y;
    private $image;

    /**
     * Sets Focal Point X
     * @param mixed $focal_point_x
     */
    public function setFocalPointX($focal_point_x): void
    {
        $this->focal_point_x = $focal_point_x;
    }

    /**
     * Sets Focal Point Y
     * @param $focal_point_y
     */
    public function setFocalPointY($focal_point_y): void
    {
        $this->focal_point_y = $focal_point_y;
    }

    /**
     * Sets Focal Point X & Y
     * @param $focal_point_x
     * @param $focal_point_y
     */
    public function setFocalPoints($focal_point_x, $focal_point_y){
        $this->focal_point_x = $focal_point_x;
        $this->focal_point_y = $focal_point_y;
    }

    /**
     * Sets height
     * @param $height
     */
    public function setHeight($height){
        $this->height=$height;
    }

    /**
     * Sets width
     * @param $width
     */
    public function setWidth($width){
        $this->width = $width;
    }

    /**
     * Sets both height and width
     * @param $height
     * @param $width
     */
    public function setDimensions($height, $width){
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * Saves $this->image to specific path
     * @param $filename
     */
    public function save($filename){

    }

    /**
     * Loads image for resizing
     * @param $filename
     */
    public function load($filename){

    }

    /**
     * Crops image
     * @param null $height
     * @param null $width
     * @param null $focal_point_x
     * @param null $focal_point_y
     */
    public function crop($height = NULL, $width = NULL, $focal_point_x = NULL, $focal_point_y = NULL){

        if($height!==NULL){
            $this->height = $height;
        }

        if($width!==NULL){
            $this->width = $width;
        }

        if($focal_point_x!==NULL){
            $this->focal_point_x = $focal_point_x;
        }

        if($focal_point_y!==NULL){
            $this->focal_point_x = $focal_point_y;
        }
    }

    /**
     * Return image object
     * @return mixed
     */
    public function get(){
        return $this->image;
    }
}