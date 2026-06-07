<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->foreignId('gedung_id')->nullable()->after('id')->constrained('gedung')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ruangan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('gedung_id');
        });
    }
};
