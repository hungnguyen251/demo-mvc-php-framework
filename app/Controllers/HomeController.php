<?php
namespace App\Controller;

use App\Models\Home;
use Controller;
use Request;
use Response;
use Session;
use Validator;

class HomeController extends Controller
{
    public $home;

    public function __construct()
    {
        $this->home = new Home();
    }
    
    public function index()
    {
        $data = $this->home->getList();
        var_dump('Đây là trang chủ');
        // print_r($data);
        
        //Check tinh nang session
        // $sessionData = Session::data('test_ss', 'test session');
        // $sessionData = Session::data();
        // $sessionData = Session::delete('test_ss');
        // Session::flash('test_flashSS','test Flash Session');
        // $sessionData = Session::flash('test_flashSS');
        // echo ($sessionData);
    }

    public function edit()
    {
        $data = $this->home->getList();
        print_r($data);
    }

    //Test validator
    public function test()
    {
        $request = new Request();
        $validator = new Validator();

        //Set rulese
        if ($request->isPost()) {
            $rules = [
                'fullname' => 'required|max:10',
                'email' => 'required|email|unique:account:email',
                'password' => 'required',
                'confirm_password' => 'required|min:3|match:password',
                'phone' => 'required|int|callback_check_phone'
            ];


            //Set rulese
            $message = [
                'fullname.required' => 'Họ tên là bắt buộc',
                'fullname.max' => 'Họ tên tối đa 10 kí tự',
                'email.required' => 'email là bắt buộc',
                'email.email' => 'Sai định dạng email',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'MK là bắt buộc',
                'confirm_password.required' => 'Nhập lại MK là bắt buộc',
                'confirm_password.min' => 'MK nhập lại là bắt buộc',
                'confirm_password.match' => 'MK không khớp',
                'phone.required' => 'SDT là bắt buộc',
                'phone.int' => 'SDT là số nguyên',
                'phone.callback_check_phone' => 'Sai định dạng SĐT',
            ];

            $validate = $validator->make($rules,$message);

            //Trả ra lỗi của tất cả trường
            echo '<pre>';
            print_r($validator->errors());
            echo '</pre>';

            //In lỗi ra view
            if (!$validate) {  //check không tồn tại các rules
                //Truong hop su dung Session
                $this->data['errors'] = Session::flash('errors_validate', $validator->errors());
                $this->data['msg'] = Session::flash('msg', 'Đã xảy ra lỗi, vui lòng thử lại');
                $this->data['msg'] = Session::flash('old_data', $request->getFields());
            }    
        }
        $this->data['errors'] = Session::flash('errors');
        $this->data['msg'] = Session::flash('msg');
        $this->data['old'] = Session::flash('old');
        $this->render('homes/test',$this->data);
    }
}