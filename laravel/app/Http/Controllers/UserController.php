<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view_them_user(){
        return view('themtaikhoan');
    }
    public function them_user(Request $request){

        $validate = $request->validate(
            [
                'user_name' => 'required',
                'password' => ['required'],
                'full_name' => 'required',
                'phone' => ['required', 'regex:/^(0[3|5|7|8|9])([0-9]{8})$/']
            ],
            [
                'user_name.required' => 'User name khong duoc de trong',
                'password.required' => 'Password khong duoc de trong',
                'full_name.required' => 'Full name khong duoc de trong',
                'phone.required' => 'Phone khong duoc de trong',
                'phone.regex' => 'Phone sai dinh dang'
            ]
        );


        $u = new User($validate);
        $u -> user_name= $_POST['user_name'];
        $u -> password = bcrypt($_POST['password']);
        $u -> full_name = $_POST['full_name'];
        $u -> phone = $_POST['phone'];
        $u -> role= $_POST['role'];
        $u -> status= 1;
        $u -> save();
        return redirect('/quan-ly-tai-khoan');
    }

    public function view_update_user($id){
        $user= User::findOrFail($id);
        return view('capnhattaikhoan',['u' => $user]);
    }
    public function update_user($id, Request $request){

        $validate = $request->validate(
            [
                'full_name' => 'required',
                'phone' => ['required', 'regex:/^(0[3|5|7|8|9])([0-9]{8})$/']
            ],
            [
                'full_name.required' => 'Full name khong duoc de trong',
                'phone.required' => 'Phone khong duoc de trong',
                'phone.regex' => 'Phone sai dinh dang'
            ]
        );
        // Tìm user theo ID, nếu không tồn tại sẽ trả về lỗi 404
        $user= User::findOrFail($id);
        // Cập nhật dữ liệu từ request
        $user->full_name = $request->input('full_name');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role'); 
        $user->status = $request->input('status');
        // Lưu thay đổi
        $user->save();
        return redirect('/quan-ly-tai-khoan');
    }
    public function delete_user($id){
        $data= User::findOrFail($id);
        $data -> delete();
        return redirect('/quan-ly-tai-khoan');
    }
}
