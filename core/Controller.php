<?php

class  Controller 
{
    public $db;

    /*
    *
    *   Rendre dữ liệu từ controller ra view
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
        // extract($data);

        //Check file trước khi render
        if (file_exists('app/Views/'.$view . '.php')) {
            require_once 'app/Views/'.$view . '.php';
        }
    }
}