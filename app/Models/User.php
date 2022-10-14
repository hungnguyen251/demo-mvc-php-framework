<?php
namespace App\Models;

use Model;

class User extends Model
{
    protected $table = 'users';

    public function getList()
    {
        $data = ['Nothing in user'];
        return $data;
    }

    public function edit()
    {
        $data = ['Edit User'];
        return $data;
    }
}