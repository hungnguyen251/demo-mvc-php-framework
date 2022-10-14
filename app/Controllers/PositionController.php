<?php
namespace App\Controller;

use App\Models\Position;
use Controller;

class PositionController extends Controller 
{
    public $position;

    public function __construct()
    {
        $this->position = new Position();
    }

    public function index()
    {
        $data = $this->position->getList();
        return $data;
    }
}