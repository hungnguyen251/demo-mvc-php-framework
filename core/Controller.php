<?php

class  Controller 
{
    public $db;

    /**
     *  Xử lí load model trong controller
     */
    public function model($model) {
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
    *   Render dữ liệu từ controller ra view
    */
    public function render($view, $data=[]) {

        //Check data share sau đó merge vào data để trả ra view
        if (!empty(View::$dataShare)) {
            $data = array_merge($data, View::$dataShare);
        }
        //Đổi key của mảng thành biến: Ví dụ extract($data['user']) = $user
        if (!empty($data)) {
            extract($data);
        }
        //Check file trước khi render
        if (preg_match('~^layouts~', $view)) {
            if (file_exists('app/Views/'.$view . '.php')) {
                require_once 'app/Views/'.$view . '.php';
            }

        } else {
            $contentPage = null;
            if (file_exists(__DIR__ROOT . '/app/Views/'.$view . '.php')) {
                $contentPage = file_get_contents(__DIR__ROOT . '/app/Views/'.$view . '.php');
            }
                    
            $template = new Template();
            $template->run($contentPage, $data);
        }
    }
}