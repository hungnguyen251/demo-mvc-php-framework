<?php
namespace App\Middlewares;

use Load;
use Middlewares;
use Response;
use Session;

class AuthMiddleware extends Middlewares
{
    public function handle() {
        $testLoad = Load::model('User');
        var_dump($testLoad);
        if (null == Session::data('admin_login')) {
            $response = new Response();

            //Check người dùng đăng nhập vào trang khai báo trong config/app middleware nếu ko hợp lê sẽ chuyển đến trang chủ
            // $response->redirect('trang-chu');
        }
    }
}