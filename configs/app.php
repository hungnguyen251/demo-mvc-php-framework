<?php

use App\Core\AppServiceProvider;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\ParamsMiddleware;

$config['app'] = [
    'routeMiddleware' => [
        //Set middleware cho key route
        'nhan-vien' => AuthMiddleware::class
    ],
    'globalMiddleware' => [
        ParamsMiddleware::class
    ],
    'boot' => [
        AppServiceProvider::class   //Thiết lập config view share
    ],
];

?>