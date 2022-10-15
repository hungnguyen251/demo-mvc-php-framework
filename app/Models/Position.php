<?php 
namespace App\Models;

use Model;

class Position extends Model 
{
    protected $table = 'position';

    public function tableFill() {
        return $this->table;
    }

    public function fieldFill() {
        return '*';
    }

    public function primaryKey() {
        return 'id';
    }
    
    public function insertTest($data) {
        $this->db->table('position')->insert($data);
    }

    public function updateTest($data) {
        $this->db->table('position')->where('id','=', '42')->update($data);
    }

    public function deleteTest() {
        $this->db->table('position')->where('id','=', '43')->delete();
    }
}