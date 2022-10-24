<?php
namespace App\Controller;

use App\Models\Home;
use Controller;

class HomeController extends Controller
{
    public $home;
    public $data = [];

    public function __construct() {
        $this->home = new Home();
    }
    
    public function index() {
        $this->data['sub_content']['new_title'] = 'Trang chủ';
        $this->data['content'] = 'home/index';

        $this->render('layouts\client_layout', $this->data);
    }


    public function store($data) {
        //store
        $this->db->table('home')->insert($data);
    }

    public function show() {
        //show
        $this->db->table('home')->get();
    }

    public function update($data, $id) {
        //update
        $this->db->table('home')->where('id','=', $id)->update($data);
    }

    public function destroy($id) {
        //destroy
        $this->db->table('home')->where('id','=', $id)->delete();
    }
}
        