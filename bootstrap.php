<?php

define('__DIR__ROOT', __DIR__);

//Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $webRoot = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $webRoot = 'http://' . $_SERVER['HTTP_HOST'];
}

$dirRoot = str_replace('\\', '/', __DIR__ROOT);
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

// $character = explode('\\', strtolower(__DIR__ROOT));
// $handleCharacter = implode('/', $character);
$folder = str_replace(strtolower($documentRoot), '', strtolower($dirRoot));
// $webRoot = $webRoot . '/' . $folder;
$webRoot = $webRoot . $folder;

define('__WEB__ROOT', $webRoot);

require_once __DIR__. '/vendor/autoload.php';
$configsDir = scandir('configs');

if (!empty($configsDir)) {
    foreach ($configsDir as $item) {
        if ($item != '.' && $item != '..' && file_exists('configs/' . $item) ) {
            require_once 'configs/' . $item;
        }
    }
}

//Load load class
require_once 'core/Load.php'; 

//Load Middlewares Class
require_once 'core/Middlewares.php';

//Load Route Class
require_once 'core/Route.php';

 //Load Session Class
require_once 'core/Session.php';

//Check và load database
if (!empty($config['database'])) {
    $dbConfig = $config['database'];

    if (!empty($dbConfig)) {
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}

//Load helpers
require_once 'core/Helper.php';

$allHelpers = scandir('app/Helpers');
if (!empty($allHelpers)) {
    foreach ($allHelpers as $item) {
        if ($item != '.' && $item != '..' && file_exists('app/Helpers/' . $item)) {
            require_once ('app/Helpers/' . $item);
        }
    }
}

 //Load App
require_once 'app/App.php';

//Load Service Provider Class
require_once 'core/ServiceProvider.php'; 

//Load View Class
require_once 'core/View.php';

//Load Base Model
require_once 'core/Model.php';

//Load Template Class
require_once 'core/Template.php'; 

//Load base controller
require_once 'core/Controller.php';

//Load Request Class
require_once 'core/Request.php';

//Load Validator Class
require_once 'core/Validator.php';

//Load Response Class
require_once 'core/Response.php';

//Load JsonResponse Class
require_once 'core/JsonResponse.php';