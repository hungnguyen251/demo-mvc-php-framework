<?php

$routes['default_controller'] = 'home';
$routes['nhan-vien'] = 'user/index';
$routes['trang-chu'] = 'home';
$routes['nhan-vien'] = 'user/index';
$routes['nhan-vien/(.+)'] = 'user/edit/$1';
// $routes['nhan-vien/.+(\d).html'] = 'user/edit/$1';
$routes['vi-tri/(.+)'] = 'position/getpositionbyid/$1';