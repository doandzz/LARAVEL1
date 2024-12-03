<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\TeacherEditRequest;
use App\Http\Requests\TeacherCreateRequest;

class TeacherController extends Controller
{
    public function list(Request $request)
    {   
        //Search
        $name_search = $request->input('name_search');
        $teacher_code_search = $request->input('teacher_code_search');

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $teachers = Teacher::when($teacher_code_search, function($queryBuilder) use ($teacher_code_search){
            $queryBuilder -> where('teacher_code','LIKE',"%{$teacher_code_search}%");
        })
        -> when($name_search, function($queryBuilder) use($name_search){
            $queryBuilder -> where('full_name','LIKE',"%{$name_search}%");
        })
        ->where('status', 1)->orderBy('updated_at', 'desc')->paginate($custom)->withQueryString();

        foreach ($teachers as $data) {
            $data->gender_str = $data->gender === 1 ? 'Nam' : 'Nữ';
            $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
        }

        return view('teachers.list', compact('teachers','teacher_code_search','name_search'));
    }

    public function view_create(Request $request)
    {   
        session()->forget('success');
        return view('teachers.create');
    }
    public function create(TeacherCreateRequest $request)
    {   
        
        $user = new User;
        $validateData = $request -> validated();
        $roleAdmin = (int) $request->input('roleAdmin', 0);
        
        $user -> role = $roleAdmin;
        $user -> user_name = $validateData['identification_code'];
        $user -> password = bcrypt($validateData['password']);
        $user -> full_name = $validateData['full_name'];
        $user -> phone = $validateData['phone'];
        $user -> email = $validateData['email'];
        $user -> status = 1;

        $user -> save();

        $teacher = new Teacher();

        $newUser = User::where('identification_code',$validateData['identification_code'])->first();

        $teacher -> identification_code = $validateData['identification_code'];
        $teacher -> teacher_code = $validateData['teacher_code'];
        $teacher -> full_name = $validateData['full_name'];
        $teacher -> birth_date = $validateData['birth_date'];
        $teacher -> phone = $validateData['phone'];
        $teacher -> email = $validateData['email'];
        $teacher -> address = $validateData ['address'];
        $teacher -> gender = $_POST['gender'];
        $teacher -> status = 1;
        $teacher -> user_id = $newUser -> id;
        // Check if there are new photos uploaded
        if ($request->hasFile('face_url')) {
            // Save the new image to the public/images folder
            $image = $request->file('face_url');
            $filename = $teacher-> teacher_code . '_' . 0 .".png";
            $image->storeAs('images', $filename, 'public');
            
            $teacher->face_url = $filename;  //Save image path in DB
        }
        $teacher->save();
        session()-> flash('success','Thêm giáo viên thành công');

        return redirect()->route('management-teachers.list');
    }


    public function view_edit(Teacher $teacher)
    {   
        return view('teachers.edit', compact('teacher'));
    }
    public function edit(Teacher $teacher, TeacherEditRequest $request)
    {   
        $validateData = $request -> validated();

        $roleAdmin = (int) $request->input('roleAdmin', 0);
        
        if(isset($teacher->user)){
            $user = User::where('id',$teacher->user->id)->first();
            $user -> role = $roleAdmin;
        }
        $teacher -> identification_code = $validateData['identification_code'];
        $teacher -> teacher_code = $validateData['teacher_code'];
        $teacher -> full_name = $validateData['full_name'];
        $teacher -> birth_date = $validateData['birth_date'];
        $teacher -> email = $validateData['email'];
        $teacher -> phone = $validateData['phone'];
        $teacher -> address = $validateData ['address'];
        $teacher -> gender = $_POST['gender'];
        
        // Check if there are new photos uploaded
        if ($request->hasFile('face_url')) {
            // Delete old photos if any
            if ($teacher->face_url && file_exists(public_path('images/' . $teacher->face_url))) {
                unlink(public_path('images/' . $teacher->face_url));
            }
        
            // Save the new image to the public/images folder
            $image = $request->file('face_url');
            $filename = $teacher-> teacher_code . '_' . 0 .".png";
            $image->storeAs('images', $filename, 'public');
            
            $teacher->face_url = $filename;  //Save image path in DB
        }
        
        $teacher->save();
        session()-> flash('success','Thông tin đã được cập nhật');

        return redirect()->route('management-teachers.list');
    }

    public function delete(Teacher $teacher)
    {
        $teacher = Teacher::find($teacher->id);
        $teacher->status = 0;
        $teacher->save();
        session()-> flash('success','Xóa giáo viên thành công');
        return redirect()->route('management-teachers.list');
    }

}