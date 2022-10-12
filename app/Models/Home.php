<?php
namespace App\Models;

class Home
{
    protected $table = 'users';

    public function getList()
    {
        $data = ['Nothing in home'];
        return $data;
    }
}