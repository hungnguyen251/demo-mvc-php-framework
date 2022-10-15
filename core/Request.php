<?php

class Request
{
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost() {
        if ($this->getMethod() == 'post') {
            return true;
        }

        return false;
    }

    public function isGet() {
        if ($this->getMethod() == 'get') {
            return true;
        }

        return false;
    }

    public function getFields() {
        $dataField = [];

        if ($this->isGet()) {
            //Xử lý lấy dữ liệu với method GET
            if (!empty($_GET)) {
                foreach ($_GET as $key=>$value) {
                    if (is_array($value)) {
                        $dataField[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataField[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        
        if ($this->isPost()) {
            //Xử lý lấy dữ liệu với method POST
            if (!empty($_POST)) {
                foreach ($_POST as $key=>$value) {
                    if (is_array($value)) {
                        $dataField[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataField[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }  
            
        }

        return $dataField;
    }
}