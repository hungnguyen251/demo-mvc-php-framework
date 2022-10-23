<?php
namespace App\Middlewares;

use Middlewares;
use Response;
use Route;

class ParamsMiddleware extends Middlewares
{
    /**
     * Hàm xử lí nếu có query string sẽ trả về đường dẫn gốc và loại bỏ query string
     */
    public function handle() {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $response = new Response();
            $response->redirect(Route::getFullUrl());
        }
    }
}