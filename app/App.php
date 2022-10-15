<?php
namespace App;

use Route;
use DB;

class App {

    private $__controller; 
    private $__action;
    private $__params;
    private $__routes;
    private $__db;

    function __construct()
    {
        global $routes;

        $this->__routes = new Route();

        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];

        //Xử lý để Controller cũng có thể sử dụng được Query Builder
        if (class_exists('DB')) {
            $dbObject = new DB();
            $this->__db = $dbObject->db; 
        }

        $this->handleUrl();
    }

    function getUrl()
    {
        if(!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }

        return $url;
    }

    public function handleUrl() 
    {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);

        $urlArr = array_filter(explode('/',$url));
        $urlArr = array_values($urlArr);

        //Handle controllers
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]) . 'Controller';
        } else {
            $this->__controller = ucfirst($this->__controller) . 'Controller';
        }

        if (file_exists('app/controllers/'.($this->__controller) . '.php')) {
            // require_once __DIR__ . './Controllers/' . ($this->__controller) . '.php';
            require_once ('App\\Controllers\\' . ($this->__controller) . '.php');
            $className = "App\Controller\\" . $this->__controller;
            if (class_exists($className)) {
                $this->__controller = new $className();
                unset($urlArr[0]);

                //Xử lý để Controller cũng có thể sử dụng được Query Builder
                if (!empty($this->__db)) {
                    $this->__controller->db = $this->__db; 
                }
        
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }

        //Handle action
        if (!empty($urlArr[1])) {
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }

        //Handle params
        $this->__params = array_values($urlArr);
        
        //Check method exist
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
    }

    public function loadError($name = '404') 
    {
        require_once 'error/' . $name . '.php';
    }
}