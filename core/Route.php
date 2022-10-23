<?php

use App\App;

class Route 
{
    private $keyRoute = null;
    function handleRoute($url) 
    {
        global $routes;
        unset($routes['default_controller']);

        $url = trim($url, '/');
        $handleUrl = $url;
        if (!empty($routes)) {
            foreach ($routes as $key=>$value) {
                if (preg_match('~' . $key . '~is', $url)) {
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);
                    $this->keyRoute = $key;
                }
            }
        }
        
        return $handleUrl;
    }

    /**
     * Tạo function lấy ra uri key trong cấu hình config/route
     */
    public function getUri() {
        return $this->keyRoute;
    }

    /**
     * Lấy ra đường dẫn
     */
    static public function getFullUrl() {
        $uri = App::$app->getUrl();
        $url = __WEB__ROOT . $uri;
        return $url;
    }
}