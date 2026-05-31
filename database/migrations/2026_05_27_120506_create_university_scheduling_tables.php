<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['theory', 'lab']);
            $table->integer('capacity')->default(0);
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('sks');
            $table->enum('type', ['theory', 'lab']);
            $table->timestamps();
        });

        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Senin, Selasa, etc.
            $table->timestamps();
        });

        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Slot 1, Slot 2, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        Schema::create('course_offerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lecturer_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g., "Kelas A"
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_offering_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('day_id')->constrained()->cascadeOnDelete();
            $table->foreignId('start_time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->string('batch_id')->index(); // To identify a GA run
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('course_offerings');
        Schema::dropIfExists('time_slots');
        Schema::dropIfExists('days');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('lecturers');
    }
};
