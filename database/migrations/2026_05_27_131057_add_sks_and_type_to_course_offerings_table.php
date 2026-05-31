<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_offerings', function (Blueprint $table) {
            $table->integer('sks')->nullable()->after('room_id');
            $table->enum('type', ['theory', 'lab'])->nullable()->after('sks');
        });
        
        // Data migration: copy existing sks/type from courses to offerings if any
        DB::statement('UPDATE course_offerings co JOIN courses c ON co.course_id = c.id SET co.sks = c.sks, co.type = c.type');
    }

    public function down(): void
    {
        Schema::table('course_offerings', function (Blueprint $table) {
            $table->dropColumn(['sks', 'type']);
        });
    }
};
