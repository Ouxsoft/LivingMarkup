<?php

namespace LivingMarkup;

/**
 * Class Router
 * @package LivingMarkup
 */
class Router
{

    private $route;

    /**
     * Router constructor.
     */
    function __construct()
    {
        $route = (array_key_exists('REDIRECT_URL', $_SERVER))?$_SERVER['REDIRECT_URL']:'';

        $this->request($route);
    }

    /**
     * @param string $route
     */
    public function request(string $route){
        $route = (string) ltrim($route, '/');

        // send empty request to home
        if($route==''){ $route = 'home';}

        // check for file as php file if a extension not provided in request
        $route .= (pathinfo($route)['extension']=='')?'.php':'';

        // check for directory traversal or if file does not exist
        $real_base = realpath(PUBLIC_DIR);
        $user_path = PUBLIC_DIR . $this->route;
        $real_user_path = realpath($user_path);
        if (($real_user_path === false) || (strpos($real_user_path, $real_base) !== 0) || (is_file($this->route) == false)) {
            // return 404 page
            $this->route = '404.php';
        }

        $this->route = $route;
    }


    public function response(){
        require $this->route;
    }
}
