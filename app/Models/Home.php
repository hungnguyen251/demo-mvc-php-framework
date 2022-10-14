<?php
namespace App\Models;

use Model;

class Home extends Model
{
    protected $table = 'home';

    public function getList()
    {
        $data = ['Nothing in home'];
        return $data;
    }
}