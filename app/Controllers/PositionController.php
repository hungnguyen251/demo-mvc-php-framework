<?php
namespace App\Controller;

use App\Models\Position;
use Controller;

class PositionController extends Controller 
{
    public $position;

    public function __construct() {
        $this->position = new Position();
    }

    public function index() {
        $data = $this->db->table('position')->where('id','=', '16')->get();
        print_r($data);
        return $data;
    }

    public function find() {
        $data = $this->position->findById(17);
        return $data;
    }

    public function insertData() {
        $data = [
            'position_code' => 'MCV1569203222',
            'position_name' => 'Lao công',
            'salary_per_day' => 100000,
        ];

        $this->position->insertTest($data);
    }

    public function updateData() {
        $data = [
            'position_code' => 'MCV156920211',
            'position_name' => 'Làm vì đam mê',
            'salary_per_day' => 120000,
        ];

        $this->position->updateTest($data);
    }

    public function deleteData() {
        $this->position->deleteTest();
    }
}