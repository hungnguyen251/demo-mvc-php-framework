<?php

define('__DIR__ROOT', __DIR__);
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

require_once 'core/Model.php'; //Load Base Model
require_once 'core/Controller.php'; //Load base controller