<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Confirmed_attendance;
use App\Models\Settings_time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    private function getClassData($className, $class_size, $statusAttendance, $startOfDay, $endOfDay)
    {

        return Classes::where('name', 'LIKE', $className)
            ->when($statusAttendance != 0, function ($query) use ($statusAttendance, $startOfDay, $endOfDay) {
                if ($statusAttendance == 1) {
                    $query->whereHas('confirmed_attendance', function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
                    });
                } elseif ($statusAttendance == 2) {
                    $query->whereDoesntHave('confirmed_attendance');
                }
            })
            ->when($class_size != 0, function ($query) use ($class_size, $startOfDay, $endOfDay) {
                $query->withCount([
                    'students',
                    'students as students_attended_count' => function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                            $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                                ->groupBy('student_identification_code');
                        });
                    }
                ]);

                if ($class_size == 1) {
                    $query->havingRaw('students_count = students_attended_count');
                } elseif ($class_size == 2) {
                    $query->havingRaw('students_count > students_attended_count');
                }
            })
            ->withCount([
                'students',
                'students as students_attended_count' => function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                            ->groupBy('student_identification_code');
                    });
                },
                'confirmed_attendance' => function ($query) use ($startOfDay, $endOfDay) {
                    $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
                }
            ])
            ->get();
    }

    public function index(Request $request)
    {
        if (!Gate::allows('view-admin-dashboard')) {
            if (request()->has('date') && request()->date) {
                $currentDate = Carbon::parse(request()->date);  // Convert to Carbon if it's a valid date
            } else {
                $currentDate = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
            }

            $user = Auth::user();

            //Get the start and end times of the current day
            $startOfDay = $currentDate->copy()->startOfDay();
            $endOfDay = $currentDate->copy()->endOfDay();
            $statusAttendance = $request->get('status_attendance', 0);
            $class_size = $request->get('class_size', 0);

            $classes = Classes::where('teacher_id', $user->teacher->id)
                ->when($statusAttendance != 0, function ($query) use ($statusAttendance, $startOfDay, $endOfDay) {
                    if ($statusAttendance == 1) {
                        $query->whereHas('confirmed_attendance', function ($query) use ($startOfDay, $endOfDay) {
                            $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
                        });
                    } elseif ($statusAttendance == 2) {
                        $query->whereDoesntHave('confirmed_attendance');
                    }
                })
                ->when($class_size != 0, function ($query) use ($class_size, $startOfDay, $endOfDay) {
                    $query->withCount([
                        'students',
                        'students as students_attended_count' => function ($query) use ($startOfDay, $endOfDay) {
                            $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                                $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                                    ->groupBy('student_identification_code');
                            });
                        }
                    ]);

                    if ($class_size == 1) {
                        $query->havingRaw('students_count = students_attended_count');
                    } elseif ($class_size == 2) {
                        $query->havingRaw('students_count > students_attended_count');
                    }
                })
                ->withCount([
                    'students',
                    'students as students_attended_count' => function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereHas('attendances', function ($query) use ($startOfDay, $endOfDay) {
                            $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                                ->groupBy('student_identification_code');
                        });
                    },
                    'confirmed_attendance' => function ($query) use ($startOfDay, $endOfDay) {
                        $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
                    }
                ])
                ->get();

            $is_teacher = true;

            return view('attendance.list', [
                'currentDate' => $currentDate,
                'classes' => $classes,
                'is_teacher' => $is_teacher,
                'statusAttendance' => $statusAttendance,
                'class_size' => $class_size
            ]);
        }

        if (request()->has('date') && request()->date) {
            $currentDate = Carbon::parse(request()->date);  // Convert to Carbon if it's a valid date
        } else {
            $currentDate = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
        }

        //Get the start and end times of the current day
        $startOfDay = $currentDate->copy()->startOfDay();
        $endOfDay = $currentDate->copy()->endOfDay();
        $statusAttendance = $request->get('status_attendance', 0);
        $class_size = $request->get('class_size', 0);

        $grade_1 = $this->getClassData('1%', $class_size, $statusAttendance, $startOfDay, $endOfDay);
        $grade_2 = $this->getClassData('2%', $class_size, $statusAttendance, $startOfDay, $endOfDay);
        $grade_3 = $this->getClassData('3%', $class_size, $statusAttendance, $startOfDay, $endOfDay);
        $grade_4 = $this->getClassData('4%', $class_size, $statusAttendance, $startOfDay, $endOfDay);
        $grade_5 = $this->getClassData('5%', $class_size, $statusAttendance, $startOfDay, $endOfDay);
        $is_teacher = false;

        return view('attendance.list', [
            'currentDate' => $currentDate,
            'grade_5' => $grade_5,
            'grade_4' => $grade_4,
            'grade_3' => $grade_3,
            'grade_2' => $grade_2,
            'grade_1' => $grade_1,
            'is_teacher' => $is_teacher,
            'statusAttendance' => $statusAttendance,
            'class_size' => $class_size
        ]);
    }
    public function view_detail(Classes $class, $currentDate)
    {
        $currentDate = Carbon::createFromFormat('Y-m-d', $currentDate);
        $day_name = $currentDate->locale('en')->dayName;

        $setting_time = Settings_time::where('day', 'LIKE', $day_name)->first();

        //Get the start and end times of the current day
        $startOfDay = $currentDate->copy()->startOfDay();
        $endOfDay = $currentDate->copy()->endOfDay();

        $class->load(['students.attendances' => function ($query) use ($startOfDay, $endOfDay) {
            $query->whereBetween('time_in', [$startOfDay, $endOfDay])
                ->limit(1);
        }]);

        $studentsWithoutFaceHistory = $class->students()
            ->doesntHave('attendances', 'and', function ($query) use ($startOfDay, $endOfDay) {
                $query->whereBetween('time_in', [$startOfDay, $endOfDay]);
            })
            ->count();

        $confirmed_attendance = $class->confirmed_attendance()
            ->whereBetween('confirmation_time', [$startOfDay, $endOfDay])
            ->count();

        foreach ($class->students as $data) {
            $data->birth_date = Carbon::parse($data->birth_date)->format('d/m/Y');
        }

        return view('attendance.detail', [
            'class' => $class,
            'currentDate' => $currentDate,
            'setting_time' => $setting_time,
            'studentsWithoutFaceHistory' => $studentsWithoutFaceHistory,
            'confirmed_attendance' => $confirmed_attendance
        ]);
    }
    public function edit_status_attendance(Classes $class, $currentDate, Request $request)
    {
        $timeInData = $request->input('time_in', []);
        $statusData = $request->input('status', []);
        $userId = Auth::id(); //user id

        foreach ($statusData as $key => $status) {

            if (str_starts_with($key, 'new') && $status != 2) {
                $studentId = str_replace('new-', '', $key);
                $time_In = $timeInData[$key] ?? null;
                if ($time_In) {
                    $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
                    $time_In = Carbon::createFromFormat('Y-m-d H:i', $now . ' ' . $time_In);
                }

                $attendance = new Attendance();

                $attendance->student_id = $studentId;
                $attendance->class_id = $class->id;
                $attendance->time_in = $time_In;
                $attendance->user_id = $userId;
                $attendance->type = 0;
                $attendance->status = $status;
                $attendance->save();
            } else {
                $attendance = Attendance::find($key);

                if ($attendance) {
                    $time_In = $timeInData[$key] ?? null;
                    if ($time_In) {
                        $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
                        $time_In = Carbon::createFromFormat('Y-m-d H:i', $now . ' ' . $time_In);
                    }
                    $attendance->status = $status;
                    $attendance->user_id = $userId;
                    $attendance->time_in = $time_In;
                    $attendance->save();
                }
            }
        }

        $currentDate = Carbon::createFromFormat('Y-m-d', $currentDate);
        session()->flash('success', 'Điểm danh đã được cập nhật!');

        return redirect()->route('management-attendances.view_detail', [
            'class' => $class,
            'currentDate' => $currentDate->format('Y-m-d')
        ]);
    }
    public function confirmed_attendance(Classes $class, $currentDate, Request $request)
    {
        $timeInData = $request->input('time_in', []);
        $statusData = $request->input('status', []);
        $userId = Auth::id();

        foreach ($statusData as $key => $status) {

            if (str_starts_with($key, 'new') && $status != 2) {
                $studentId = str_replace('new-', '', $key);
                $time_In = $timeInData[$key] ?? null;
                if ($time_In) {
                    $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
                    $time_In = Carbon::createFromFormat('Y-m-d H:i', $now . ' ' . $time_In);
                }

                $attendance = new Attendance();

                $attendance->student_id = $studentId;
                $attendance->class_id = $class->id;
                $attendance->time_in = $time_In;
                $attendance->user_id = $userId;
                $attendance->type = 0;
                $attendance->status = $status;
                $attendance->save();
            } else {
                $attendance = Attendance::find($key);

                if ($attendance) {
                    $time_In = $timeInData[$key] ?? null;
                    if ($time_In) {
                        $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
                        $time_In = Carbon::createFromFormat('Y-m-d H:i', $now . ' ' . $time_In);
                    }
                    $attendance->status = $status;
                    $attendance->user_id = $userId;
                    $attendance->time_in = $time_In;
                    $attendance->save();
                }
            }
        }
        $currentDate = Carbon::createFromFormat('Y-m-d', $currentDate);
        session()->flash('success', 'Điểm danh đã được xác nhận!');

        $confirmed_attendance = new Confirmed_attendance();

        $confirmed_attendance->user_id = $userId;
        $confirmed_attendance->class_id = $class->id;
        $confirmed_attendance->confirmation_time = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

        $confirmed_attendance->save();
        session()->flash('success', 'Điểm danh đã được xác nhận!');

        return redirect()->route('management-attendances.view_detail', [
            'class' => $class,
            'currentDate' => $currentDate->format('Y-m-d')
        ]);
    }
}
