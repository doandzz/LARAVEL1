<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Year;
use App\Models\Teacher;
use App\Http\Requests\ClassEditRequest;
use App\Http\Requests\ClassCreateRequest;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $name_search = $request->input('name_search');
        $grade_search = $request->input('grade_search', 0);
        $request->session()->put('name_search', $name_search);
        $request->session()->put('grade_search', $grade_search);

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::when($name_search, function ($query) use ($name_search) {
            $query->whereHas('teacher', function ($teacherQuery) use ($name_search) {
                $teacherQuery->where('full_name', 'LIKE', "%{$name_search}%");
            });
        })
            ->when($grade_search, function ($queryBuilder) use ($grade_search) {
                if ($grade_search != 0) {
                    $queryBuilder->where('name', 'LIKE', "{$grade_search}%");
                }
            })
            ->where('status', 1)->orderBy('id', 'desc')->paginate($custom)->withQueryString();

        $years = Year::get();
        $teachers = Teacher::get();

        return view('classes.list', [
            'classes' => $classes,
            'years' => $years,
            'teachers' => $teachers,
            'name_search' => $name_search,
            'grade_search' => $grade_search
        ]);
    }

    public function view_edit(Classes $class, Request $request)
    {
        $name_search = $request->session()->get('name_search');
        $grade_search = $request->session()->get('grade_search');
        $showFilter = true;
        if (isNull($name_search) && $grade_search == 0) {
            $showFilter = false;
        }

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::when($name_search, function ($query) use ($name_search) {
            $query->whereHas('teacher', function ($teacherQuery) use ($name_search) {
                $teacherQuery->where('full_name', 'LIKE', "%{$name_search}%");
            });
        })
            ->when($grade_search, function ($queryBuilder) use ($grade_search) {
                if ($grade_search != 0) {
                    $queryBuilder->where('name', 'LIKE', "{$grade_search}%");
                }
            })
            ->where('status', 1)->orderBy('id', 'desc')->paginate($custom)->withQueryString();
        $years = Year::get();
        $teachers = Teacher::get();
        $classname = $class->name;

        return view('classes.list', compact('classes', 'class', 'years', 'teachers', 'classname', 'name_search', 'grade_search', 'showFilter'));

    }

    public function edit(ClassEditRequest $request, Classes $class)
    {

        $validatedData = $request->validated();
        $class->name = $validatedData['name'];
        $class->year_id = $validatedData['year_id'];
        $class->teacher_id = $validatedData['teacher_id'];

        $class->update();

        // Flash message
        session()->flash('success', 'Thông tin đã được cập nhật!');

        return redirect()->route('management-classes.list');
    }
    public function view_create(Request $request)
    {
        $name_search = $request->session()->get('name_search');
        $grade_search = $request->session()->get('grade_search');
        $showFilter = true;
        if (isNull($name_search) && $grade_search == 0) {
            $showFilter = false;
        }

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::when($name_search, function ($query) use ($name_search) {
            $query->whereHas('teacher', function ($teacherQuery) use ($name_search) {
                $teacherQuery->where('full_name', 'LIKE', "%{$name_search}%");
            });
        })
            ->when($grade_search, function ($queryBuilder) use ($grade_search) {
                if ($grade_search != 0) {
                    $queryBuilder->where('name', 'LIKE', "{$grade_search}%");
                }
            })
            ->where('status', 1)->orderBy('id', 'desc')->paginate($custom)->withQueryString();

        $years = Year::get();
        $teachers = Teacher::get();

        // Remove 'class' object from session
        $request->session()->forget('class');

        return view('classes.list', compact('classes', 'years', 'teachers', 'name_search', 'grade_search', 'showFilter'));
    }
    public function create(ClassCreateRequest $request)
    {
        $class = new Classes();
        $validatedData = $request->validated();

        $class->name = $validatedData['name'];
        $class->year_id = $validatedData['year_id'];
        $class->teacher_id = $validatedData['teacher_id'];
        $class->status = 1;

        $class->save();

        // Flash message
        session()->flash('success', 'Thêm lớp học thành công!');

        return redirect()->route('management-classes.list');
    }
    public function delete(Classes $class)
    {
        $class = Classes::find($class->id);
        $class->status = 0;
        $class->save();
        // Flash message
        session()->flash('success', 'Xóa lớp học thành công!');
        return redirect()->route('management-classes.list');
    }
    public function clear_fillter(Request $request)
    {
        $name_search = '';
        $grade_search = 0;
        $request->session()->forget(['name_search', 'grade_search']);

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $classes = Classes::where('status', 1)->orderBy('id', 'desc')->paginate($custom)->withQueryString();

        $years = Year::get();
        $teachers = Teacher::get();

        return view('classes.list', [
            'classes' => $classes,
            'years' => $years,
            'teachers' => $teachers,
            'name_search' => $name_search,
            'grade_search' => $grade_search,
            'showFilter' => true
        ]);
    }
}
