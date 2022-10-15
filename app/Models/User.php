<?php
namespace App\Models;

use Model;

class User extends Model
{
    protected $table = 'users';

    public function tableFill() {
        return $this->table;
    }

    public function fieldFill() {
        return '*';
    }

    public function primaryKey() {
        return 'id';
    } 

    public function getList() {
        $data = ['Nothing in user'];
        return $data;
    }

    public function edit() {
        $data = ['Edit User'];
        return $data;
    }
}