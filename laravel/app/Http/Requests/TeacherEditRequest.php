<?php 
namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherEditRequest extends FormRequest
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
        $teacherId = $this->route('teacher')->id;
        return [
            'identification_code' => ['required','regex:/^[a-zA-Z0-9_]{8,12}$/',Rule::unique($table, 'identification_code')->ignore($teacherId),],
            'teacher_code' => ['required','regex:/^[a-zA-Z0-9_]{8,12}$/',Rule::unique($table, 'teacher_code')->ignore($teacherId),],
            'full_name' => 'required|regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơỲỴÝỶỸỳỵýỷỹỤụƯưĂăẰằẮắẲẳẴẵẶặẸẹẺẻẼẽỀềẾếỂểỄễỆệỈỉỊịỌọỎỏỎỏỐốỒồỔổỖỗỘộỚớỜờỞởỠỡỢợỤụỦủỨứỪừỬửỮữỰự\s]+$/',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => ['required','regex:/^0\d{9}$/',Rule::unique($table, 'phone')->ignore($teacherId),],
            'email' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', Rule::unique($table, 'email')->ignore($teacherId),],
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
            'identification_code.regex' => 'Mã định danh phải từ 8-12 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới (_)!',
            'identification_code.unique' => 'Mã định danh giáo viên đã tồn tại!',
            'teacher_code.required' => 'Vui lòng nhập mã giáo viên!',
            'teacher_code.regex' => 'Mã giáo viên phải từ 8-12 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới (_)!',
            'teacher_code.unique' => 'Mã giáo viên đã tồn tại!',
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
