<?php
namespace App;

use Route;
use DB;

class App 
{

    private $__controller; 
    private $__action;
    private $__params;
    private $__routes;
    private $__db;
    static public $app;

    function __construct() {
        global $routes, $config;

        self::$app = $this;

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

    function getUrl() {
        if(!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }

        return $url;
    }

    public function handleUrl() {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);

        $urlArr = array_filter(explode('/',$url));
        $urlArr = array_values($urlArr);

        //Xử lí Middleware
        $this->handleGlobalMiddleware($this->__db);
        $this->handleRouteMiddleware($this->__routes->getUri(), $this->__db);

        //Gọi ra hàm handleAppServiceProvider
        $this->handleAppServiceProvider($this->__db);

        //Handle controllers
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]) . 'Controller';
        } else {
            $this->__controller = ucfirst($this->__controller) . 'Controller';
        }

        if (file_exists('app/controllers/'.($this->__controller) . '.php')) {
            // require_once __DIR__ . './Controllers/' . ($this->__controller) . '.php';
            require_once ('App/Controllers/' . ($this->__controller) . '.php');
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

    /**
     * Lấy ra tên controller
     */
    public function getCurrentController() {
        return $this->__controller;
    }

    public function loadError($name = '404',$data=[]) {
        if (!empty($data)) {
            extract($data);
        }

        require_once 'error/' . $name . '.php';
    }

    public function handleRouteMiddleware($keyRoute, $db) {
        global $config;
        $keyRoute = trim($keyRoute);

        //Check config middleware va require
        if (!empty($config['app']['routeMiddleware'])) {
            $routeMiddlewareArr = $config['app']['routeMiddleware'];

            foreach ($routeMiddlewareArr as $key=>$middlewareItem) {
                if (trim($key) == $keyRoute && file_exists($middlewareItem . '.php')) {
                    require_once $middlewareItem  . '.php';

                    if (class_exists($middlewareItem)) {
                        $middlewareObj = new $middlewareItem();

                        if (!empty($db)) {
                            $middlewareObj->db = $db;
                        }
                        $middlewareObj->handle();
                    }
                }
            }
        }
    }

    public function handleGlobalMiddleware($db) {
        global $config;

        //Check config middleware va require
        if (!empty($config['app']['globalMiddleware'])) {
            $globalMiddlewareArr = $config['app']['globalMiddleware'];

            foreach ($globalMiddlewareArr as $middlewareItem) {
                if (file_exists($middlewareItem . '.php')) {
                    require_once $middlewareItem  . '.php';

                    if (class_exists($middlewareItem)) {
                        $middlewareObj = new $middlewareItem();

                        if (!empty($db)) {
                            $middlewareObj->db = $db;
                        }
                        $middlewareObj->handle();
                    }
                }
            }
        }
    }

    /**
     * Hàm xử lý Service Provider
     */
    public function handleAppServiceProvider($db) {
        global $config;
        if (!empty($config['app']['boot'])) {
            $serviceProviderArr = $config['app']['boot'];
            foreach ($serviceProviderArr as $serviceName) {
                if (file_exists($serviceName . '.php')) {
                    require_once $serviceName . '.php';

                    if (class_exists($serviceName)) {
                        $serviceObject = new $serviceName();
                        
                        if (!empty($db)) {
                            $serviceObject->db = $db;
                        }

                        $serviceObject->boot();
                    }
                }
            }
        }
    }
}