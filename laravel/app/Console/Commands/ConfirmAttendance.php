<?php

namespace App\Console\Commands;

use App\Models\Classes;
use App\Models\Confirmed_attendance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

class ConfirmAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        

        $currentDate = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

        //Get the start and end times of the current day
        $startOfDay = $currentDate->copy()->startOfDay();
        $endOfDay = $currentDate->copy()->endOfDay();

        $classes = Classes::doesntHave('confirmed_attendance', 'and', function ($query) use ($startOfDay, $endOfDay) {
            $query->whereBetween('confirmation_time', [$startOfDay, $endOfDay]);
        });

        foreach ($classes as $class) {
            $confirmed_attendance = new Confirmed_attendance();

            $confirmed_attendance->class_id = $class->id;
            $confirmed_attendance->confirmation_time = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

            $confirmed_attendance->save();
        }
    }
}
