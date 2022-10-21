<?php
namespace App\Core;

use ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Xử lý dữ liệu View share
     */
    public function boot() {
        $data['copyright'] = 'Copyright &copy; 2022 by HungNguyen';
        View::share($data);
    }
}   
