<?php
namespace App\Models;

use Model;
use Request;
use Response;
use Session;

class Home extends Model
{
    protected $table = 'home';

    public function tableFill() {
        return $this->table;
    }

    public function fieldFill() {
        return '*';
    }

    public function primaryKey() {
        return 'id';
    }

    public function post() {
        $request = new Request();

        //Set rulese
        if ($request->isPost()) {
            $request->rules([
                'fullname' => 'required|max:10',
                'email' => 'required|email|unique:account:email',
            ]);


            //Set rulese
            $request->message([
                'fullname.required' => 'Họ tên là bắt buộc',
                'fullname.max' => 'Họ tên tối đa 10 kí tự',
                'email.required' => 'email là bắt buộc',
                'email.email' => 'Sai định dạng email',
                'email.unique' => 'Email đã tồn tại',
            ]);

            $validate = $request->validate();

            //In lỗi ra view
            if (!$validate) {  //check không tồn tại các rules
                //Truong hop su dung Session
                Session::flash('errors_validate', $request->errors());
                Session::flash('msg', 'Đã xảy ra lỗi, vui lòng thử lại');
                Session::flash('old_data', $request->getFields());
            }    
        }

        $reponse = new Response;
        $reponse->redirect('/');
    }
}