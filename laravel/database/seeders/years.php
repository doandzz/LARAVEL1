<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class years extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('years')->insert([
            ['name'=> '2024-2025']
        ]);
    }
}
