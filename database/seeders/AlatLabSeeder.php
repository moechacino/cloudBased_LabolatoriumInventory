<?php

namespace Database\Seeders;

use App\Models\Alat_Lab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlatLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alat_Lab::factory()->count(12)->create();
    }
}
