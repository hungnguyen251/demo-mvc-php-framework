<?php
namespace App\Controller;

use App\Models\User;
use Controller;
use Request;
use Response;
use Session;
use Validator;

class UserController extends Controller
{
    public $user, $dataErrors;

    public function __construct()
    {
        $this->user = new User();
    }
    
    public function index()
    {
        echo 'Index User';
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
        // $request = new Request();
        // $data = $request->getFields();

        //Sau khi set session ở postUser và redirect về getUser, lấy ra session
        $this->data['errors'] = Session::flash('errors');
        $this->data['msg'] = Session::flash('msg');
        $this->data['old'] = Session::flash('old');
        $this->render('users/add', $this->data);
    }

    public function postUser() {
        $request = new Request();

        //Set rulese
        if ($request->isPost()) {
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
                // $this->dataErrors['errors'] = $request->errors();
                // $this->dataErrors['old'] = $request->getFields(); //Lưu dữ liệu người dùng đã nhập để trả ra khi nhập lại

                //Truong hop su dung Session
                Session::flash('errors_validate', $request->errors());
                Session::flash('msg', 'Đã xảy ra lỗi, vui lòng thử lại');
                Session::flash('old_data', $request->getFields());
            }
            // $this->render('users/add', $this->dataErrors);   //Dùng cho trường hợp gửi lỗi không dùng session
    
        }
        $reponse = new Response;
        $reponse->redirect('user/postuser');

        // $validator = new Validator();
        // var_dump($validator);
    }

    // Hàm check để có thể tự custom các validate mà không dùng mặc định
    public  function check_phone($phone) {
        if (strlen($phone) > 10) {
            return true;
        } 

        return false;
    }
}