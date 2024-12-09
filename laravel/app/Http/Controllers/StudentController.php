<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StudentEditRequest;
use App\Http\Requests\StudentCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    public function list(Request $request)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            $user = Auth::user();

            $name_search = $request->input('name_search');
            $class_search = $request->input('class_search');

            $custom = $request->input('pageinateData') ?? 10;
            $request->session()->put('custom', $custom);

            $query = Student::when($name_search, function ($queryBuilder) use ($name_search) {
                $queryBuilder->where('full_name', 'LIKE', "%{$name_search}%");
            })
                ->when($class_search, function ($queryBuilder) use ($class_search) {
                    if ($class_search != 0) {
                        $queryBuilder->where('class_id', $class_search);
                    }
                })
                ->where('status', 1)
                ->whereIn('class_id', $user->teacher->classes->pluck('id'));
            
            $totalStudents = (clone $query)->count();

            $students= $query->orderBy('id', 'asc')->paginate($custom)->withQueryString();

            foreach ($students as $data) {
                $data->gender_str = $data->gender === 1 ? 'Nam' : 'Nữ';
                $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
            }

            $is_teacher = true;
            $classes = Classes::get();

            return view('students.list', compact('students', 'classes', 'name_search', 'class_search', 'is_teacher', 'totalStudents'));
        }


        $name_search = $request->input('name_search');
        $class_search = $request->input('class_search');

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $query = Student::when($name_search, function ($queryBuilder) use ($name_search) {
            $queryBuilder->where('full_name', 'LIKE', "%{$name_search}%");
        })
            ->when($class_search, function ($queryBuilder) use ($class_search) {
                if ($class_search != 0) {
                    $queryBuilder->where('class_id', $class_search);
                }
            })
            ->where('status', 1);
        
        $totalStudents = (clone $query)->count();

        $students = $query ->orderBy('id', 'asc')->paginate($custom)->withQueryString();

        foreach ($students as $data) {
            $data->gender_str = $data->gender === 1 ? 'Nam' : 'Nữ';
            $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
        }

        $classes = Classes::get();
        $is_teacher = true;

        return view('students.list', compact('students', 'classes', 'name_search', 'class_search', 'is_teacher', 'totalStudents'));
    }

    public function view_create()
    {
        $classes = Classes::get();

        return view('students.create', compact('classes'));
    }

    public function create(StudentCreateRequest $request)
    {
        $student = new Student();
        $validatedData = $request->validated();

        $student->student_identification_code = $validatedData['student_identification_code'];
        $student->student_code = $validatedData['student_code'];
        $student->class_id = $validatedData['class_id'];
        $student->full_name = $validatedData['full_name'];
        $student->birth_date = $validatedData['birth_date'];
        $student->gender = $_POST['gender'];
        $student->address = $validatedData['address'];
        $student->guardian_phone = $validatedData['guardian_phone'];
        $student->guardian_full_name = $validatedData['guardian_full_name'];
        $student->status = 1;
        // Check if there are new photos uploaded
        if ($request->hasFile('student_face_url')) {
            // Save the new image to the public/images folder
            $image = $request->file('student_face_url');
            $filename =  $student->student_identification_code . '_' . 0 . ".png";
            $image->storeAs('images', $filename, 'public');

            $student->student_face_url = $filename;  //Save image path in DB
        }
        $student->save();

        // Flash message
        session()->flash('success', 'Thêm học sinh thành công');

        return redirect()->route('management-students.list');
    }

    public function view_edit(Student $student)
    {
        $classes = Classes::get();

        return view('students.edit', compact('classes', 'student'));
    }

    public function edit(Student $student, StudentEditRequest $request)
    {

        $validatedData = $request->validated();

        $student->student_identification_code = $validatedData['student_identification_code'];
        $student->student_code = $validatedData['student_code'];
        $student->class_id = $validatedData['class_id'];
        $student->full_name = $validatedData['full_name'];
        $student->birth_date = $validatedData['birth_date'];
        $student->gender = $_POST['gender'];
        $student->address = $validatedData['address'];
        $student->guardian_phone = $validatedData['guardian_phone'];
        $student->guardian_full_name = $validatedData['guardian_full_name'];
        // Check if there are new photos uploaded
        if ($request->hasFile('student_face_url')) {
            // Delete old photos if any
            if ($student->student_face_url && file_exists(public_path('images/' . $student->student_face_url))) {
                unlink(public_path('images/' . $student->student_face_url));
            }

            // Save the new image to the public/images folder
            $image = $request->file('student_face_url');
            $filename = $student->student_identification_code . '_' . 0 . ".png";
            $image->storeAs('images', $filename, 'public');

            $student->student_face_url = $filename;  //Save image path in DB
        }

        $student->save();

        // Flash message
        session()->flash('success', 'Thông tin đã được cập nhật');

        return redirect()->route('management-students.list');
    }

    public function delete(Student $student)
    {
        $student = Student::find($student->id);
        $student->status = 0;
        $student->save();

        // Flash message
        session()->flash('success', 'Xóa học sinh thành công');

        return redirect()->route('management-students.list');
    }

    public function clear_fillter(Request $request)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            $user = Auth::user();

            $name_search = '';
            $class_search = 0;

            $custom = $request->input('pageinateData') ?? 10;
            $request->session()->put('custom', $custom);

            $students = Student::where('status', 1)
                ->whereIn('class_id', $user->teacher->classes->pluck('id'))
                ->orderBy('id', 'desc')->paginate($custom)->withQueryString();

            foreach ($students as $data) {
                $data->gender_str = $data->gender === 1 ? 'Nam' : 'Nữ';
                $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
            }

            $is_teacher = true;
            $classes = Classes::get();
            $showFilter = true;

            return view('students.list', compact('students', 'classes', 'name_search', 'class_search', 'is_teacher', 'showFilter'));
        }


        $name_search = '';
        $class_search = 0;

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $query = Student::where('status', 1);

        $totalStudents = (clone $query)->count();

        $students = $query ->orderBy('id', 'desc')->paginate($custom)->withQueryString();

        foreach ($students as $data) {
            $data->gender_str = $data->gender === 1 ? 'Nam' : 'Nữ';
            $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
        }

        $classes = Classes::get();
        $is_teacher = false;
        $showFilter = true;

        return view('students.list', compact('students', 'classes', 'name_search', 'class_search', 'is_teacher', 'showFilter','totalStudents'));
    }


    public function importStudentPage()
    {
        $classes = Classes::get();
        return view('students.import',  compact('classes'));
    }

    public function importStudents() {}

    public function exportStudentPage()
    {
        return view('students.export');
    }

    public function exportStudents() {}
}
