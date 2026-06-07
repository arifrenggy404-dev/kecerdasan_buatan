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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tipe', ['teori', 'praktikum']);
            $table->integer('kapasitas')->default(0);
            $table->timestamps();
        });

        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->integer('sks');
            $table->enum('tipe', ['teori', 'praktikum']);
            $table->timestamps();
        });

        Schema::create('hari', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Senin, Selasa, etc.
            $table->timestamps();
        });

        Schema::create('slot_waktu', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Slot 1, Slot 2, etc.
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosen')->cascadeOnDelete();
            $table->string('nama'); // e.g., "Kelas A"
            $table->timestamps();
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->foreignId('hari_id')->constrained('hari')->cascadeOnDelete();
            $table->foreignId('slot_waktu_mulai_id')->constrained('slot_waktu')->cascadeOnDelete();
            $table->string('id_batch')->index(); // To identify a GA run
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('slot_waktu');
        Schema::dropIfExists('hari');
        Schema::dropIfExists('mata_kuliah');
        Schema::dropIfExists('ruangan');
        Schema::dropIfExists('dosen');
    }
};
