<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class classes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->insert([
            ['name'=> '1A1','status' => 1],
            ['name'=> '1A2','status' => 1],
            ['name'=> '1A3','status' => 1],
            ['name'=> '1A4','status' => 1],
            ['name'=> '1A5','status' => 1],
            ['name'=> '1A6','status' => 1],
            ['name'=> '1A7','status' => 1],
            ['name'=> '1A8','status' => 1],
            ['name'=> '2A1','status' => 1],
            ['name'=> '2A2','status' => 1],
            ['name'=> '2A3','status' => 1],
            ['name'=> '2A4','status' => 1],
            ['name'=> '2A5','status' => 1],
            ['name'=> '2A6','status' => 1],
            ['name'=> '2A7','status' => 1],
            ['name'=> '3A1','status' => 1],
            ['name'=> '3A2','status' => 1],
            ['name'=> '3A3','status' => 1],
            ['name'=> '3A4','status' => 1],
            ['name'=> '3A5','status' => 1],
            ['name'=> '3A6','status' => 1],
            ['name'=> '4A1','status' => 1],
            ['name'=> '4A2','status' => 1],
            ['name'=> '4A3','status' => 1],
            ['name'=> '4A4','status' => 1],
            ['name'=> '4A5','status' => 1],
            ['name'=> '4A6','status' => 1],
            ['name'=> '4A7','status' => 1],
            ['name'=> '5A1','status' => 1],
            ['name'=> '5A2','status' => 1],
            ['name'=> '5A3','status' => 1],
            ['name'=> '5A4','status' => 1],
            ['name'=> '5A5','status' => 1],
            ['name'=> '5A6','status' => 1],
            ['name'=> '5A7','status' => 1]
        ]);
    }
}
