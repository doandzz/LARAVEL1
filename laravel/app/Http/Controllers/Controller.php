<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;
use App\Models\Attendance;
use App\Models\Classes;

abstract class Controller
{
    //
    public function getTable($table_name){
        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        return $tenant->code."_".$table_name;
    }

    public function getAttendanceModel(){
        $tableName  =  $this->getTable('attendance');
        $attendance = new Attendance();
        $AttendanceModel = $attendance->setTable($tableName);
        return $AttendanceModel;
    }

    public function getClassesModel(){
        $tableName  =  $this->getTable('classes');
        $attendance = new Classes();
        $AttendanceModel = $attendance->setTable($tableName);
        return $AttendanceModel;
    }
}
