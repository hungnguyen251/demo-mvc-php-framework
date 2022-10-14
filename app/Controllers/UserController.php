<?php
namespace App\Controller;

use App\Models\User;
use Controller;

class UserController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = new User();
    }
    
    public function index()
    {
        echo 'index User';
    }

    public function edit()
    {
        $dataUser = $this->user->edit();

        //render dữ liệu ra vieww
        $this->data['sub_content']['dataUser'] = $dataUser;
        $this->data['content'] = 'users\edit';
        $this->render('layouts\client_layout', $this->data);

        return $dataUser;
    }
}