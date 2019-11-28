<?php
namespace Pxp\DynamicElement\Widgets;

class Breadcrumb extends \Pxp\DynamicElement\DynamicElement
{

    public $separator = '/';

    public function onRender()
    {
        $pages = [
            [
                'title' => 'Home',
                'href' => '/'
            ],
            [
                'title' => 'Groups',
                'href' => '/groups'
            ],
            [
                'title' => 'User',
                'href' => '/groups/user'
            ],
            [
                'title' => 'Settings',
                'href' => '/groups/user/settings'
            ]
        ];
        
        $out = '<!-- Breadcrumb -->' . PHP_EOL;
        $out .= '<div class="breadcrumb">';
        $out .= '<ul>';
        foreach ($pages as $page) {
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