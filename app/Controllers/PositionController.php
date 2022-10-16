<?php
namespace App\Controller;

use App\Models\Position;
use Controller;
use Request;
use Response;

class PositionController extends Controller 
{
    public $position;

    public function __construct() {
        $this->position = new Position();
    }

    public function index() {
        $data = $this->db->table('position')->select('id')->whereBetween('id',[15,20])->get();
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

    public function getPosition() {
        $request = new Request();
        $data = $request->getFields();
        var_dump($data);
        $this->render('position/add');
    }

    public function postPosition() {
        $request = new Request();
        $data = $request->getFields();
        
        $reponse = new Response();
        $reponse->redirect('home/index');
    }
}