<?php 
namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentEditRequest extends FormRequest
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
        $table = $tenant->code.'_students';
        $studentId = $this->route('student')->id;
        return [
            'student_identification_code' => ['required','regex:/^[a-zA-Z0-9_]{8,12}$/',Rule::unique($table, 'student_identification_code')->ignore($studentId),],
            'student_code' => ['required','regex:/^[a-zA-Z0-9_]{8,12}$/',Rule::unique($table, 'student_code')->ignore($studentId),],
            'full_name' => 'required|regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơỲỴÝỶỸỳỵýỷỹỤụƯưĂăẰằẮắẲẳẴẵẶặẸẹẺẻẼẽỀềẾếỂểỄễỆệỈỉỊịỌọỎỏỎỏỐốỒồỔổỖỗỘộỚớỜờỞởỠỡỢợỤụỦủỨứỪừỬửỮữỰự\s]+$/',
            'class_id' => 'not_in:0',
            'birth_date' => 'required',
            'address' => 'required|string',
            'guardian_phone' => 'required|regex:/^0\d{9}$/',
            'guardian_full_name' => 'required|regex:/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơỲỴÝỶỸỳỵýỷỹỤụƯưĂăẰằẮắẲẳẴẵẶặẸẹẺẻẼẽỀềẾếỂểỄễỆệỈỉỊịỌọỎỏỎỏỐốỒồỔổỖỗỘộỚớỜờỞởỠỡỢợỤụỦủỨứỪừỬửỮữỰự\s]+$/',
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
            'student_identification_code.required' => 'Vui lòng nhập mã định danh học sinh!',
            'student_identification_code.regex' => 'Mã định danh phải từ 8-12 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới (_)!',
            'student_identification_code.unique' => 'Mã học sinh đã tồn tại!',
            'student_code.required' => 'Vui lòng nhập mã học sinh!',
            'student_code.regex' => 'Mã định danh phải từ 8-12 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới (_)!',
            'student_code.unique' => 'Mã học sinh đã tồn tại!',
            'class_id.not_in' => 'Vui lòng chọn lớp học!',
            'full_name.required' => 'Vui lòng nhập tên học sinh!',
            'full_name.regex' => 'Tên học sinh chỉ chứa chữ cái!',
            'birth_date.required' => 'Vui lòng chọn ngày sinh!',
            'address.required' => 'Vui lòng nhập địa chỉ!',
            'guardian_phone.required' => 'Vui lòng nhập số điện thoại!',
            'guardian_phone.regex' => 'Số điện thoại sai định dạng!',
            'guardian_full_name.required' => 'Vui lòng nhập học tên phụ huynh',
            'guardian_full_name.regex' => 'Tên phụ huynh chỉ chứa chữ cái',
        ];
    }
}
