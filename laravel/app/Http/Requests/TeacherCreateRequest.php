<?php 
namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherCreateRequest extends FormRequest
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
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $table = $tenant->code.'_teachers';
        return [
            'identification_code' => ['required','regex:/^[0-9]{12}$/',Rule::unique($table, 'identification_code'),],
            'password' => 'required|regex:/^\S{8,16}$/',
            'confirm_password' =>'required|same:password',
            'full_name' => 'required|regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơỲỴÝỶỸỳỵýỷỹỤụƯưĂăẰằẮắẲẳẴẵẶặẸẹẺẻẼẽỀềẾếỂểỄễỆệỈỉỊịỌọỎỏỎỏỐốỒồỔổỖỗỘộỚớỜờỞởỠỡỢợỤụỦủỨứỪừỬửỮữỰự\s]+$/',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => ['required','regex:/^0\d{9}$/',Rule::unique($table, 'phone'),],
            'email' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', Rule::unique($table, 'email'),],
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
            'identification_code.required' => 'Vui lòng nhập mã định danh giáo viên!',
            'identification_code.regex' => 'Mã định danh phải đủ 12 số!',
            'identification_code.unique' => 'Mã định danh giáo viên đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.regex' => 'Mật khẩu phải từ 8-16 ký tự và không chứa khoảng trắng!',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu!',
            'confirm_password.same' => 'Mật khẩu xác nhận không trùng khớp!',
            'full_name.required' => 'Vui lòng nhập tên giáo viên!',
            'full_name.regex' => 'Tên giáo viên chỉ chứa chữ cái!',
            'birth_date.required' => 'Vui lòng chọn ngày sinh!',
            'address.required' => 'Vui lòng nhập địa chỉ!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.regex' => 'Số điện thoại sai định dạng!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'email.required' => 'Vui lòng nhập email!',
            'email.regex' => 'Email sai định dạng!',
            'email.unique' => 'Email đã tồn tại!',
        ];
    }
}
