<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($days as $day) {
            \App\Models\Day::firstOrCreate(['name' => $day]);
        }
    }
}
