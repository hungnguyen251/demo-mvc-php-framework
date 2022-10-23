<?php

class Load 
{
    /**
     *  Xử lí load model trong controller
     */
    static public function model($model) {
        if (file_exists(__DIR__ROOT . '\App\Models\\' . $model . '.php')) {
            require_once __DIR__ROOT . '\App\Models\\' . $model . '.php';
            $classModelName = "App\Models\\" . $model;
            if (class_exists($classModelName)) {
                $model = new $classModelName();
                return $model;
            }
        }

        return false;
    }

        /*
    *   Rendre dữ liệu từ controller ra view
    */
    static public function view($view, $data=[]) {
        //Đổi key của mảng thành biến: Ví dụ extract($data['user']) = $user
        if (!empty($data)) {
            extract($data);
        }

        //Check file trước khi render
        if (file_exists('app/Views/'.$view . '.php')) {
            require_once 'app/Views/'.$view . '.php';
        }
    }
}