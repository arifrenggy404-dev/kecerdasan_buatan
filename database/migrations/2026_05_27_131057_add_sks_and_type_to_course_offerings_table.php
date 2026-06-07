<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('sks')->nullable()->after('ruangan_id');
            $table->enum('tipe', ['teori', 'praktikum'])->nullable()->after('sks');
        });
        
        // Data migration: copy existing sks/tipe from mata_kuliah to kelas if any
        DB::statement('UPDATE kelas k JOIN mata_kuliah mk ON k.mata_kuliah_id = mk.id SET k.sks = mk.sks, k.tipe = mk.tipe');
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['sks', 'tipe']);
        });
    }
};
