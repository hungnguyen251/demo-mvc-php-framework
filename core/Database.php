<?php

use App\Services\Interfaces\ICrud;

class Database implements ICrud
{
    private $__conn;

    public function __construct()
    {
        global $dbConfig;
        $this->__conn = Connection::getInstance($dbConfig);
    }

    public function insert($table, $data)
    {
        if (!empty($data)) {
            $fieldStr = '';
            $valueStr = '';
            foreach ($data as $key=>$value) {
                $fieldStr .= $key  . ',';
                $valueStr .= "'" . $value . "',";
            }

            $fieldStr = rtrim($fieldStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";
            $status = $this->query($sql);

            if ($status) {
                return true;
            }
        }
    }

    public function updateById($table,$data,$condition='')
    {
        if (!empty($data)) {
            $updateStr = '';
            foreach ($data as $key=>$value) {
                $updateStr .= "$key='$value',";
            }

            $updateStr = rtrim($updateStr, ',');

            if (!empty($condition)) {
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            } else {
                $sql = "UPDATE $table SET $updateStr";
            }

            $status = $this->query($sql);

            if ($status) {
                return true;
            }
        }
    }

    public function getData($table, $condition='')
    {
        if (!empty($condition)) {
            $sql = "SELECT * FROM $table WHERE $condition";
        } else {
            $sql = "SELECT * FROM $table";
        }

        $status = $this->query($sql);

        if ($status) {
            return true;
        }
    }

    public function delete($table, $condition='')
    {
        if (!empty($condition)) {
            $sql = "DELETE FROM $table WHERE $condition";
        } else {
            $sql = "DELETE FROM $table";
        }

        $status = $this->query($sql);

        if ($status) {
            return true;
        }
    }

    public function getCount($table)
    {
        // TODO: Implement getCount() method.
        /**
         * 
         * @var object $this
        */
        $sql = "SELECT COUNT(*) as total FROM $table";
        $countData = $this->query($sql);
        return $countData->fetchObject();
    }


    public function query($sql)
    {
        // TODO: Implement query() method.
        /**
         * 
         * @var object $this
        */
        $statement = $this->__conn->prepare($sql);
        $statement->execute();

        return $statement;
    }
}