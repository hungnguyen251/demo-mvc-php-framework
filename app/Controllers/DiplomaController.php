<?php
namespace App\Controller;

use Controller;

class DiplomaController extends Controller
{
    public $data = [];

    public function index() {
        $this->data['sub_content']['new_content'] = 'Test Template Content';
        $this->data['sub_content']['new_title'] = 'Test Template Title';
        $this->data['content'] = 'diplomas/list';

        $this->render('layouts\client_layout', $this->data);
    }
}