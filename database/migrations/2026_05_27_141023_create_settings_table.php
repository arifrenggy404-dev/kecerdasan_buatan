<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'active_days',
                'value' => json_encode([1, 2, 3, 4, 5]), // Senin - Jumat
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'operational_hours',
                'value' => json_encode(['start' => '07:30', 'end' => '17:00']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'blackout_hours',
                'value' => json_encode([
                    ['start' => '12:00', 'end' => '13:00'] // Jam Istirahat
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
