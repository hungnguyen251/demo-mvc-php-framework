<?php
namespace App\Services\Interfaces;

interface ICrud
{
    function insertData($table, $data);

    function updateById($table, $data, $condition='');

    function getData($table, $condition='');

    function deleteData($table, $condition='');

    function getCount($table);
}