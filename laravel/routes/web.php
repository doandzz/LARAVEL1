<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/////////////////////////////////////////////////
// Management Class
/////////////////////////////////////////////////
//change auth ->web
Route::middleware('auth')->group(function () {
    Route::get('/management-students',[StudentController::class,'list'])->name('management-students.list');
    Route::get('/management-students/{student}/edit',[StudentController::class,'view_edit'])->name('management-students.view_edit');
    Route::get('/management-students/{student}/delete',[StudentController::class,'delete'])->name('management-students.delete');
    Route::post('/management-students/{student}',[StudentController::class,'edit'])->name('management-students.edit');
    Route::get('/management-students/create',[StudentController::class,'view_create'])->name('management-students.view_create');
    Route::post('/management-student/create',[StudentController::class,'create'])->name('management-students.create');
    Route::get('/management-students/clear-fillter',[StudentController::class,'clear_fillter'])->name('management-students.clear_fillter');
    Route::get('/management-student/import',[StudentController::class,'importStudentPage'])->name('management-students.import');
    Route::get('/management-student/export',[StudentController::class,'exportStudentPage'])->name('management-students.export');

    Route::get('/management-classes',[ClassController::class,'index'])->name('management-classes.list');
    Route::get('/management-classes/{class}/edit', [ClassController::class, 'view_edit'])->name('management-classes.view_edit');
    Route::put('/management-classes/{class}', [ClassController::class, 'edit'])->name('management-classes.edit');
    Route::get('/management-classes/create', [ClassController::class, 'view_create'])->name('management-classes.view_create');
    Route::post('/management-class/create', [ClassController::class, 'create'])->name('management-classes.create');
    Route::get('/management-classes/{class}/delete',[ClassController::class,'delete'])->name('management-classes.delete');
    Route::get('/management-classes/clear-fillter',[ClassController::class,'clear_fillter'])->name('management-classes.clear_fillter');
    
    Route::get('/management-teachers',[TeacherController::class,'list'])->name('management-teachers.list');
    Route::get('/management-teachers/{teacher}/edit',[TeacherController::class,'view_edit'])->name('management-teachers.view_edit');
    Route::get('/management-teachers/{teacher}/delete',[TeacherController::class,'delete'])->name('management-teachers.delete');
    Route::post('/management-teachers/{teacher}',[TeacherController::class,'edit'])->name('management-teachers.edit');
    Route::get('/management-teachers/create',[TeacherController::class,'view_create'])->name('management-teachers.view_create');
    Route::post('/management-teacher/create',[TeacherController::class,'create'])->name('management-teachers.create');
    Route::get('/management-teachers/clear-fillter',[TeacherController::class,'clear_fillter'])->name('management-teachers.clear_fillter');

    Route::get('/management-settings',[SettingsController::class,'index'])->name('management-settings.list');
    Route::post('/management-settings/update',[SettingsController::class,'update'])->name('management-settings.update');

    Route::get('/management-attendances',[AttendanceController::class,'index'])->name('management-attendances.list');
    Route::get('/management-attendances/{class}/detail/{currentDate}',[AttendanceController::class,'view_detail'])->name('management-attendances.view_detail');
    Route::post('/management-attendances/{class}/status/{currentDate}',[AttendanceController::class,'edit_status_attendance'])->name('management-attendances.edit_status');
    Route::post('/management-attendances/{class}/confirmed-attendance/{currentDate}',[AttendanceController::class,'confirmed_attendance'])->name('management-attendances.confirmed_attendance');

    Route::get('/management-statistics',[StatisticsController::class,'index'])->name('management-statistics.list');

    Route::get('/test-image',[TestController::class,'test_image'])->name('test-image');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile/detail', [ProfileController::class, 'detail'])->name('profile.detail');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
