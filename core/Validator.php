<?php

use App\App;

class Validator
{
    private $__rules=[], $__message=[], $errors = [];

    public $request;
    public $db;

    public function __construct() {
        $this->db = new Database();
        $this->request = new Request();
    }

    /* 
    * Run validate
    */
    public function make($rules=[], $message) {
        $this->__message = $message;
        $this->__rules = $rules;
        $this->__rules = array_filter($this->__rules);

        $checkValidate = true;
        if (!empty($this->__rules)) {
            $dataField = $this->request->getFields();

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

        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey . '_errors_validate', $this->errors());
        Session::flash($sessionKey . '_old_data', $this->request->getFields());  //Session luu du lieu nguoi nhap

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