<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     *
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => 'required|current_password',
            'password' => 'required|regex:/^\S{8,16}$/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * mess error.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại!',
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác!',
            'password.required' => 'Vui lòng nhập mật khẩu mới!',
            'password.regex' => 'Mật khẩu phải từ 8-16 ký tự và không chứa khoảng trắng!',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu!',
            'password_confirmation.same' => 'Mật khẩu xác nhận không trùng khớp!',
        ];
    }
}
