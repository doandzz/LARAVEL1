<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class students extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'student_identification_code' => '027318002838',
                'student_code' => '2771596417',
                'full_name' => 'Trần Vy An',
                'class_id' => 1,
                'gender' => 0,
                'birth_date' => '2018-09-29',
                'birthplace' => 'Thành phố Bắc Ninh',
                'address' => 'Tỉnh Bắc Ninh',
                'guardian_full_name' => 'Trần Tuấn Vũ',
                'guardian_phone' => '0968271991',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
