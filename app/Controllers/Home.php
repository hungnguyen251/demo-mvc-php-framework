<?php
class Home 
{
    public function index()
    {
        echo 'Trang chu';
    }

    public function detail($id='', $slug='')
    {
        echo $id;
        echo $slug;
    }

    public function search()
    {
        $keyword = $_GET['keyword'];
    }
}