<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings_time;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        if (request()->has('date') && request()->date) {
            $currentDate = Carbon::parse(request()->date);  // Convert to Carbon if it's a valid date
        } else {
            $currentDate = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        }

        //Get the start and end times of the current day
        $startOfDay = $currentDate->copy()->startOfDay();
        $endOfDay = $currentDate->copy()->endOfDay();

        $classes = Classes::withCount([
            'students as student_on_time' => function ($query) use ($startOfDay, $endOfDay) {
                $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                          ->where('status', 0);
                });
            },
            'students as student_late_time' => function ($query) use ($startOfDay, $endOfDay) {
                $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                          ->where('status', 1);
                });
            },
            'students as student_absent' => function ($query) use ($startOfDay, $endOfDay) {
                $query->whereDoesntHave('attendances', function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('time_in', [$startOfDay, $endOfDay]);
                });
            },
        ])
        ->whereHas('confirmed_attendance', function ($query) use ($startOfDay, $endOfDay) {
            $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
        })
        ->get();

        $totalStudents = Student::count();
        $totalClasses = Classes::count();
        $totalTeachers = Teacher::count();
        
        return view('statistics.basic',['classes' => $classes,'currentDate' => $currentDate,
                    'totalStudents' =>$totalStudents, 'totalClasses' => $totalClasses, 'totalTeachers' => $totalTeachers]);
    }

}
