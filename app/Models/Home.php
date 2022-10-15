<?php
namespace App\Models;

use Model;

class Home extends Model
{
    protected $table = 'home';

    public function tableFill() {
        return $this->table;
    }

    public function fieldFill() {
        return '*';
    }

    public function primaryKey() {
        return 'id';
    }
    
    public function getList()
    {
        $data = ['Nothing in home'];
        return $data;
    }
}