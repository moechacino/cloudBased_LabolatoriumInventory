<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("admins")->insert([
            "username"=>"admin1",
            "name"=>"admin1",
            "phone"=>"0123",
            "password"=>"qwerty"
        ]);
    }
}
