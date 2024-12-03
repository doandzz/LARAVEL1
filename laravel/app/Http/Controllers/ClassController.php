<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Year;
use App\Models\Teacher;
use App\Http\Requests\ClassEditRequest;
use App\Http\Requests\ClassCreateRequest;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::where('status', 1)->paginate($custom)->withQueryString();

        $years = Year::get();
        $teachers = Teacher::get();

        return view('classes.list', ['classes' => $classes, 'years' => $years,'teachers' => $teachers]);
    }

    public function view_edit(Classes $class, Request $request)
    {   
        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::paginate($custom)->withQueryString();
        $years = Year::get();
        $teachers = Teacher::get();
        $classname= $class -> name;

        return view('classes.list', compact('classes', 'class', 'years','teachers','classname'));
    }

    public function edit(ClassEditRequest $request, Classes $class)
    {
        
        $validatedData = $request->validated();
        $class -> name = $validatedData['name'];
        $class -> year_id = $validatedData['year_id'];
        $class -> teacher_id = $validatedData['teacher_id'];

        $class->update();
        
        // Flash message
        session()->flash('success','Thông tin đã được cập nhật');

        return redirect()->route('management-classes.list');
    }
    public function view_create(Request $request)
    {   
        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::paginate($custom)->withQueryString();

        $years = Year::get();
        $teachers = Teacher::get();

        // Remove 'class' object from session
        $request->session()->forget('class');

        return view('classes.list', ['classes' => $classes, 'years' => $years,'teachers' => $teachers]);
    }
    public function create(ClassCreateRequest $request)
    {
        $class = new Classes();
        $validatedData = $request->validated();

        $class -> name = $validatedData['name'];
        $class -> year_id = $validatedData['year_id'];
        $class -> teacher_id = $validatedData['teacher_id'];
        $class -> status = 1;

        $class->save();
        
        // Flash message
        session()->flash('success','Thêm lớp học thành công');

        return redirect()->route('management-classes.list');
    }
    public function delete(Classes $class)
    {
        $class = Classes::find($class->id);
        $class->status = 0;
        $class->save();
        // Flash message
        session()->flash('success','Xóa lớp học thành công');
        return redirect()->route('management-classes.list');
    }
}
