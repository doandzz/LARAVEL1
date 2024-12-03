<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class attendance extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attendance')->insert([
            'student_id' => 1,
            'user_id' => 1,
            'class_id' => 1,
            'time_in' => now(),
            'time_out' => now()->addHours(8),
            'tracking_image_url' => 'image.jpg',
            'type' => 1
        ]);
    }
}
