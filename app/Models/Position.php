<?php 
namespace App\Models;

use Model;
use PDO;

class Position extends Model 
{
    protected $table = 'chuc_vu';

    public function getList() {
        $data = $this->db->query("SELECT * FROM $this->table")->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

}