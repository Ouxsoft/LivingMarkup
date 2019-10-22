<?php

namespace Partials;

class Breadcrumb extends \Pxp\Element
{
    public $separator = '/';

	public function view(){
        $pages = [
            ['title' => 'Home', 'href' => 'home.html'], 
            ['title' => 'Demo', 'href' => 'Demo']
        ];

        $out = '<!-- Breadcrumb -->' . PHP_EOL;
        $out .= '<div class="breadcrumb">';
        $out .= '<ul>';
        foreach($pages as $page){
            $out .= '<li>';
            $out .= '<a href="' . $page['href'] . '">';
            $out .= $page['title'];
            $out .= '</a>';
            $out .= ' <span class="separator">' . $this->separator . '</span>';
            $out .= '</li>';
        }
        $out .= '</ul>';
        $out .= '</div>';
        return $out;

    }
}