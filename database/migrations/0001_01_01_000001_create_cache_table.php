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
        Schema::create('tembolok', function (Blueprint $table) {
            $table->string('kunci')->primary();
            $table->mediumText('nilai');
            $table->bigInteger('kadaluarsa')->index();
        });

        Schema::create('kunci_tembolok', function (Blueprint $table) {
            $table->string('kunci')->primary();
            $table->string('owner');
            $table->bigInteger('kadaluarsa')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tembolok');
        Schema::dropIfExists('kunci_tembolok');
    }
};
