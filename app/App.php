<?php
class App {

    private $__controller; 
    private $__action;
    private $__params;

    function __construct()
    {
        global $routes;
        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }

        $this->__action = 'index';
        $this->__params = [];

        $url = $this->handleUrl();
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
        $urlArr = array_filter(explode('/',$url));
        $urlArr = array_values($urlArr);

        //Handle controllers
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/'.($this->__controller). '.php')) {
            require_once 'controllers/' . ($this->__controller) . '.php';
            $this->__controller = new $this->__controller();
            unset($urlArr[0]);
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
        
        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }

    public function loadError($name = '404') 
    {
        require_once 'error/' . $name . '.php';
    }
}