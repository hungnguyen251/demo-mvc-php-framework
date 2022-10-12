<?php
namespace App\Controller;

use App\Models\Home;

class HomeController
{
    public $home;

    public function __construct()
    {
        $this->home = new Home();
    }
    
    public function index()
    {
        $data = $this->home->getList();
        print_r($data);
    }

    public function edit()
    {
        $data = $this->home->getList();
        print_r($data);
    }
}