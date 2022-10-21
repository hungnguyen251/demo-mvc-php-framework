<?php

class View 
{
    /**
     * Share dữ liệu đến các view tương ứng
     */
    static public $dataShare = [];

    static public function share($data) {
        self::$dataShare = $data;
    }
}