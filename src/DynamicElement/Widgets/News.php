<?php
/*
 * <widget name="News">
 * <arg name="heading">Latest News</arg>
 * <arg name="heading_level">3</arg>
 * </widget>
 */
namespace Pxp\DynamicElement\Widgets;

class News extends \Pxp\DynamicElement\DynamicElement
{

    public $heading_level = 3;

    public function onRender()
    {
        $out = '';
        
        // add widget comment
        if (isset($this->args['id'])) {
            $out .= '<!-- widget #' . $this->args['id'] . '-->' . PHP_EOL;
        }
        
        // heading
        if (isset($this->args['heading'])) {
            if (isset($this->args['heading_level']) && (in_array($this->args['heading_level'], range(1, 6)))) {
                $this->heading_level = $this->args['heading_level'];
            }
            
            $out .= '<h' . $this->heading_level . '>' . $this->args['heading'] . '</h' . $this->heading_level . '>';
        }
        
        /*
         * $out .= '<ul>';
         * foreach($this->myGenerator() as $row){
         * $out .= '<li>' . $row . '</li>';
         * }
         * $out .= '</ul>';
         */
        return $out;
    }
}