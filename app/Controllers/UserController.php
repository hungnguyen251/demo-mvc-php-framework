<?php
namespace App\Controller;

use App\Models\User;
use Controller;
use Request;
use Response;

class UserController extends Controller
{
    public $user, $dataErrors;

    public function __construct()
    {
        $this->user = new User();
    }
    
    public function index()
    {
        echo 'index User';
    }

    public function edit()
    {
        $dataUser = $this->user->edit();

        //render dữ liệu ra vieww
        $this->data['sub_content']['dataUser'] = $dataUser;
        $this->data['content'] = 'users\edit';
        $this->render('layouts\client_layout', $this->data);

        return $dataUser;
    }

    public function getUser() {
        $request = new Request();
        $data = $request->getFields();
        var_dump($data);
        $this->render('users/add');
    }

    public function postUser() {
        $request = new Request();

        //Set rulese
        $request->rules([
            'fullname' => 'required|max:10',
            'email' => 'required|email|unique:account:email',
            'password' => 'required',
            'confirm_password' => 'required|min:3|match:password',
            'phone' => 'required|int|callback_check_phone'
        ]);


        //Set rulese
        $request->message([
            'fullname.required' => 'Họ tên là bắt buộc',
            'fullname.max' => 'Họ tên tối đa 10 kí tự',
            'email.required' => 'email là bắt buộc',
            'email.email' => 'Sai định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'MK là bắt buộc',
            'confirm_password.required' => 'MK là bắt buộc',
            'confirm_password.min' => 'MK nhập lại là bắt buộc',
            'confirm_password.match' => 'MK không khớp',
            'phone.required' => 'SDT là bắt buộc',
            'phone.int' => 'SDT là số nguyên',
            'phone.callback_check_phone' => 'Sai định dạng SĐT',
        ]);

        $validate = $request->validate();

        // //Trả ra lỗi của tất cả trường
        // echo '<pre>';
        // print_r($request->errors);
        // echo '</pre>';

        // //Trả ra lỗi của trường chỉ định
        // echo '<pre>';
        // print_r($request->errors['fullname']);
        // echo '</pre>';

        //In lỗi ra view
        if (!$validate) {  //check không tồn tại các rules
            $this->dataErrors['errors'] = $request->errors();
            $this->dataErrors['old'] = $request->getFields(); //Lưu dữ liệu người dùng đã nhập để trả ra khi nhập lại
        }
        $this->render('users/add', $this->dataErrors);
    }

    // Hàm check để có thể tự custom các validate mà không dùng mặc định
    public  function check_phone($phone) {
        if (strlen($phone) > 10) {
            return true;
        } 

        return false;
    }
}