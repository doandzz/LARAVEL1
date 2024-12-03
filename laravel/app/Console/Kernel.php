<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('attendance:confirm')
        ->dailyAt('23:00') // Chạy vào 23 giờ mỗi ngày
        ->days([1, 2, 3, 4, 5, 6])
        ->timezone('Asia/Ho_Chi_Minh');
    }
}
