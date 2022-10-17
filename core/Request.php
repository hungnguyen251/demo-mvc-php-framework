<?php

use App\App;

class Request
{
    private $__rules=[], $__message=[], $errors = [];
    public $db;

    public function __construct() {
        $this->db = new Database();
    }

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

    /* 
    * Set rulse
    */
    public function rules($rules=[]) {
        $this->__rules = $rules;
    }

    /* 
    * Set message
    */
    public function message($message) {
        $this->__message = $message;
    }

    /* 
    * Run validate
    */
    public function validate() {
        $this->__rules = array_filter($this->__rules);

        $checkValidate = true;
        if (!empty($this->__rules)) {
            $dataField = $this->getFields();

            foreach ($this->__rules as $fieldName=>$ruleItem) {
                $ruleItemArr = explode('|', $ruleItem);

                foreach ($ruleItemArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;

                    $rulesArr = explode(':', $rules);

                    //Hàm reset() lấy phần tử đầu tiên của mảng
                    $ruleName = reset($rulesArr);

                    if (count($rulesArr) > 1) {
                        //Hàm end() lấy phần tử cuối của mảng
                        $ruleValue = end($rulesArr);
                    }

                    if ('required' == $ruleName) {
                        //Điều kiện kiểm tra nếu nhập vào rỗng
                        if (empty($dataField[$fieldName])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('min' == $ruleName) {
                        //Điều kiện so sánh độ dài của chuỗi nhập vào với điều kiện đưa ra
                        if (!empty($dataField[$fieldName]) && strlen(trim($dataField[$fieldName])) < $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('max' == $ruleName) {
                        //Điều kiện so sánh độ dài của chuỗi nhập vào với điều kiện đưa ra
                        if (!empty($dataField[$fieldName]) && strlen(trim($dataField[$fieldName])) > $ruleValue) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('email' == $ruleName) {
                        //Điều kiện kiểm tra định dạng email
                        if (!empty($dataField[$fieldName]) && !filter_var($dataField[$fieldName], FILTER_VALIDATE_EMAIL)) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('int' == $ruleName) {
                        //Điều kiện kiểm tra định dạng số nguyên
                        if (!empty($dataField[$fieldName]) && !filter_var($dataField[$fieldName], FILTER_VALIDATE_INT)) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('match' == $ruleName) {
                        //Điều kiện so khớp mật khẩu ...
                        if (!empty($dataField[$fieldName]) && trim($dataField[$fieldName]) != trim($dataField[$ruleValue])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ('unique' == $ruleName) {
                        //Điều kiện giá trị là duy nhất ...
                        $tableName = null;
                        $fieldCheck = null;

                        if (!empty($rulesArr[1])) {
                            $tableName = $rulesArr[1];
                        }

                        if (!empty($rulesArr[2])) {
                            $fieldCheck = $rulesArr[2];
                        }

                        if (!empty($dataField[$fieldName]) && !empty($fieldCheck) && !empty($tableName)) {
                            $checkExits = $this->db->query("SELECT $fieldCheck FROM $tableName WHERE $fieldCheck='trim($dataField[$fieldName])'")->rowCount();
                            if (!empty($checkExits)) {
                                $this->setErrors($fieldName, $ruleName);
                                $checkValidate = false;
                            }
    
                        }
                    }

                    //Callback validate để custom validate tự do, ..etc sử dụng Regular Expression
                    if (preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) {
                        if (!empty($dataField[$fieldName]) && !empty($callbackArr[1])) {
                            //Lấy ra kiểu check : exp check_phone, check_age
                            $callbackName = $callbackArr[1];

                            //Lấy ra tên controller hiện tại
                            $controllerName = App::$app->getCurrentController();

                            //Check tồn tại phương thức của đối tượng $controllerName
                            if (method_exists($controllerName, $callbackName)) {
                                $checkCallback = call_user_func_array([$controllerName, $callbackName], [trim($dataField[$fieldName])]);
                            
                                if (!$checkCallback) {
                                    $this->setErrors($fieldName,$ruleName);
                                    $checkValidate = false;
                                }
                            }
                        }
                    }
                    /** 
                     * Có thể làm thêm các điều kiện :
                     * date, nullable, digits(độ dài số nguyên),numeric,string
                    */
                }
            }
        }

        //Nếu không tồn tại rules return ra true
        return $checkValidate;
    }

    /* 
    * Throw error
    */
    public function errors($fieldName='') {
        if (!empty($this->errors)) {
            //Trả ra lỗi của trường chỉ định
            if (empty($fieldName)) {
                $errorArr = [];
                //Kiểm tra lỗi và chỉ lấy ra lỗi đầu tiên của 1 trường không lấy toàn bộ
                foreach ($this->errors as $key=>$error) {
                    $errorArr[$key] = reset($error);
                }
                return $errorArr;
            }

            return reset($this->errors[$fieldName]);
        }

        return false;
    }

    public function setErrors($fieldName, $ruleName) {
        $this->errors[$fieldName][$ruleName] = $this->__message[$fieldName . '.' . $ruleName];
    }
}