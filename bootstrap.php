<?php

define('__DIR__ROOT', __DIR__);

//Xử lý http root
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $webRoot = 'https://' . $_SERVER['HTTP_HOST'];
} else {
    $webRoot = 'http://' . $_SERVER['HTTP_HOST'];
}

$character = explode('\\', strtolower(__DIR__ROOT));
$handleCharacter = implode('/', $character);
$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', $handleCharacter);
$webRoot = $webRoot . '/' . $folder;

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

require_once 'core/Route.php'; //Load Route class
require_once 'core/Session.php'; //Load Session
require_once 'app/App.php'; //Load App

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

require_once 'core/ServiceProvider.php'; //Load Service Provider Class
require_once 'core/View.php'; //Load View Class

require_once 'core/Model.php'; //Load Base Model
require_once 'core/Controller.php'; //Load base controller
require_once 'core/Request.php'; //Load Request
require_once 'core/Response.php'; //Load Response