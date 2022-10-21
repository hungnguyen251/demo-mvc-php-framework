<?php
namespace App\Controller;

use App\Models\Home;
use Controller;
use Session;

class HomeController extends Controller
{
    public $home;

    public function __construct()
    {
        $this->home = new Home();
    }
    
    public function index()
    {
        $data = $this->home->getList();
        // print_r($data);
        
        //Check tinh nang session
        // $sessionData = Session::data('test_ss', 'test session');
        // $sessionData = Session::data();
        // $sessionData = Session::delete('test_ss');
        // Session::flash('test_flashSS','test Flash Session');
        // $sessionData = Session::flash('test_flashSS');
        // echo ($sessionData);
    }

    public function edit()
    {
        $data = $this->home->getList();
        print_r($data);
    }
}