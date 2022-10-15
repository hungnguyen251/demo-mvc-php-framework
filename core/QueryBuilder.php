<?php

trait QueryBuilder
{
    public $tableName = '';
    public $where = '';
    public $operator = '';
    public $selectField = '*';
    public $limit = '';
    public $orderBy = '';
    public $innerJoin = '';

    public function table($tableName) {
        $this->tableName = $tableName;
        return $this;   //return $this để Model có thể gọi nối tiếp
    }

    /*
    *   Xây dựng điều kiện WHERE
    */
    public function where($field, $compare, $value) {
        if (empty($this->where)) {
            $this->operator = ' WHERE';
        } else {
            $this->operator = ' AND';
        }
        $this->where .= "$this->operator $field $compare '$value'";

        return $this;     //return $this để Model có thể gọi nối tiếp
    }

    /*
    *   Xây dựng điều kiện OR WHERE
    */
    public function orWhere($field, $compare, $value) {
        if (empty($this->where)) {
            $this->operator = ' WHERE';
        } else {
            $this->operator = ' OR';
        }
        $this->where .= "$this->operator $field $compare '$value'";

        return $this;     //return $this để Model có thể gọi nối tiếp
    }

    /*
    *   Xây dựng điều kiện WHERE LIKE
    */
    public function whereLike($field, $value) {
        if (empty($this->where)) {
            $this->operator = ' WHERE';
        } else {
            $this->operator = ' AND';
        }
        $this->where .= "$this->operator $field LIKE '$value'";

        return $this;     //return $this để Model có thể gọi nối tiếp
    }

    /*
    *   Xây dựng tính năng select các trường
    */
    public function select($field='*') {
        $this->selectField = $field;
        return $this;
    }

    /*
    *   Xây dựng tính năng giới hạn LIMIT
    */
    public function limit($number, $offset=0) {
        $this->limit = "LIMIT $offset, $number";
        return $this;
    }

    /*
    *   Xây dựng tính năng sắp xếp ORDER BY
    */
    public function orderBy($field, $type='ASC') {
        $fieldArr = array_filter(explode(',', $field));
        if (!empty($fieldArr) && count($fieldArr) > 2) {
            $this->orderBy = "ORDER BY " . implode(', ', $fieldArr);
        } else {
            $this->orderBy = "ORDER BY ".$field ." ". $type;
        }
        return $this;
    }

    /*
    *   Xây dựng tính năng liên kết giữa các bảng INNER JOIN
    */
    public function join($tableName, $relation) {
        $this->innerJoin .= 'INNER JOIN ' .$tableName.' ON '.$relation.' ';
        return $this;
    }

    /*
    *   Thêm dữ liệu vào DB INSERT
    */
    public function insert($data) {
        $tableName = $this->tableName;
        $insertStatus = $this->insertData($tableName,$data);
        return $insertStatus;
    }

    /*
    *   Sửa dữ liệu trong DB UPDATE
    */
    public function update($data) {
        $tableName = $this->tableName;
        //Loai bo tu WHERE tranh bi lap vi ham tao trong Database.php da co dieu kien where
        $whereUpdate = str_replace('WHERE', '', $this->where);
        $whereUpdate = trim($whereUpdate);

        $updateStatus = $this->updateById($tableName, $data, $whereUpdate);
        return $updateStatus;
    }

    /*
    *   Xóa dữ liệu trong DB DELETE
    */
    public function delete() {
        $tableName = $this->tableName;

        //Loai bo tu WHERE tranh bi lap vi ham tao trong Database.php da co dieu kien where
        $whereDelete = str_replace('WHERE', '', $this->where);
        $whereDelete = trim($whereDelete);

        $deleteStatus = $this->deleteData($tableName, $whereDelete);
        return $deleteStatus;
    }

    /*
    *   Lấy ra các cả bản ghi trong DB theo điều kiện
    */
    public function get() {
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit";
        $query = $this->query($sqlQuery);

        //Reset field de tranh bi luu du lieu khi goi lai
        $this->resetQuery();

        if (!empty($query)) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /*
    *   Lấy ra  bản ghi đầu tiên trong DB theo điều kiện
    */
    public function first() {
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->where";
        $query = $this->query($sqlQuery);

        //Reset field de tranh bi luu du lieu khi goi lai
        $this->resetQuery();

        if (!empty($query)) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /*
    *   Reset các trường tránh lỗi lưu dữ liệu khi gọi lại
    */
    public function resetQuery() {
        $this->tableName = '';
        $this->where = '';
        $this->operator = '';
        $this->selectField = '*';
        $this->limit = '';
        $this->orderBy = '';
        $this->innerJoin = '';
    }
}