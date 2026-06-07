<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique();
            $table->json('nilai')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('pengaturan')->insert([
            [
                'kunci' => 'hari_aktif',
                'nilai' => json_encode([1, 2, 3, 4, 5]), // Senin - Jumat
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunci' => 'jam_operasional',
                'nilai' => json_encode(['mulai' => '07:30', 'selesai' => '17:00']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunci' => 'jam_istirahat',
                'nilai' => json_encode([
                    ['mulai' => '12:00', 'selesai' => '13:00'] // Jam Istirahat
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
