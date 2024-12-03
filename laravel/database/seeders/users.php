<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['user_name'=> 'tuananh123', 'password' => bcrypt('tuananh123'), 'full_name'=>'Nguyen Hoang Tuan Anh','phone'=>'0865858245','role'=>1,'status'=>1],
            ['user_name'=> 'phuong1234', 'password' => bcrypt('phuong123'), 'full_name'=>'Hoang Hoai Phuong','phone'=>'0375491095','role'=>0,'status'=>1]
        ]);
    }
}
