<?php 
namespace App\Http\Requests;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClassCreateRequest extends FormRequest
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
        $table = $tenant->code.'_classes';
        return [
            'name' => ['required', Rule::unique($table,'name'),],
            'year_id' => 'not_in:0',
            'teacher_id' => 'not_in:0',
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
            'name.required' => 'Vui lòng nhập tên lớp học!',
            'name.unique' => 'Tên lớp học đã tồn tại!',
            'year_id.not_in' => 'Vui lòng chọn năm học!',
            'teacher_id.not_in' => 'Vui lòng chọn giáo viên!',
        ];
    }
}
