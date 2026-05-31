<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_offerings', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->after('lecturer_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('course_offerings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('room_id');
            $table->string('name')->nullable(false)->change();
        });
    }
};
