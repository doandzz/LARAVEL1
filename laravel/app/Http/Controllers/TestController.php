<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Face_history;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TestController extends Controller{
    public function test_image(Request $request){

        $name_search = $request->input('name_search');
        $class_search = $request->input('class_search');
        if (request()->has('date') && request()->date) {
            $currentDate = Carbon::parse(request()->date);  // Convert to Carbon if it's a valid date
        } else {
            $currentDate = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        }

        $startOfDay = $currentDate->copy()->startOfDay();
        $endOfDay = $currentDate->copy()->endOfDay();

        $custom = $request->input('pageinateData') ?? 10;
        $request->session()->put('custom', $custom);

        $face_historys = Face_history::with('student')
    ->when($name_search, function ($queryBuilder) use ($name_search) {
        $queryBuilder->whereHas('student', function ($query) use ($name_search) {
            $query->where('full_name', 'LIKE', "%{$name_search}%")
            ->orWhere('student_identification_code','LIKE', "%{$name_search}%");
        });
    })
    ->when($class_search, function ($queryBuilder) use ($class_search) {
        if ($class_search != 0) {
            $queryBuilder->whereHas('student', function ($query) use ($class_search) {
                $query->where('class_id', $class_search);
            });
        }
    })
    ->when($currentDate, function ($queryBuilder) use ($startOfDay, $endOfDay){
        $queryBuilder->whereHas('student', function ($query) use ($startOfDay, $endOfDay) {
            $query->whereBetween('datetime', [$startOfDay, $endOfDay]);
        });
    })
    ->orderBy('datetime', 'desc')
    ->paginate($custom)
    ->withQueryString();

        $classes = Classes::get();
        return view('test.test_image', compact('face_historys','name_search','class_search','classes','currentDate') );
    }
}
