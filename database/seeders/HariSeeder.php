<?php

namespace Database\Seeders;

use App\Models\Hari;
use Illuminate\Database\Seeder;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        foreach ($hari as $h) {
            Hari::firstOrCreate(['nama' => $h]);
        }
    }
}
