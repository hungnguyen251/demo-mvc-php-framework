<?php

class Connection 
{
    private static $instance = null, $connection = null;

    public function __construct($config) {
        //Mở kết nối đến CSDL
        try {
            $con = new PDO('mysql:host=' . $config['host'] .';dbname=' . $config['db'], $config['user'], $config['password']);
            //sẽ ném ra exception nếu như câu lệnh SQL thực thi bị lỗi
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection = $con;
        } catch (Exception $exception) {
            echo "Lỗi kết nối đến CSDL";
            $mess = $exception->getMessage();
            die($mess);
        }
    }

    // TODO: function getInstance.
    /**
     * Nếu chưa tồn tại connection thì tạo mới không thì sẽ sử dụng connection cũ
     *
    */
    public static function getInstance($config) {
        if (self::$instance == null) {
            $conn = new Connection($config);
            self::$instance = self::$connection;
        }

        return self::$instance;
    }
}