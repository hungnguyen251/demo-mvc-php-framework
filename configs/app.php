<?php

use App\Core\AppServiceProvider;

$config['app'] = [
    'boot' => [
        AppServiceProvider::class   //Thiết lập config view share
    ],
];

?>