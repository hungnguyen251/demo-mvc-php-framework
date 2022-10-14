<?php
namespace App\Services\Interfaces;

interface ICrud
{
    function insert($table, $data);

    function updateById($table, $data, $condition='');

    function getData($table, $condition='');

    function delete($table, $condition='');

    function getCount($table);
}