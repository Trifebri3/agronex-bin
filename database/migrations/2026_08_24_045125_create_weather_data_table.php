<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();

            $table->float('suhu')->nullable();
            $table->float('kelembapan')->nullable();
            $table->float('tekanan')->nullable();
            $table->float('cahaya')->nullable();
            $table->float('kecepatan_angin')->nullable();
            $table->integer('curah_hujan')->nullable();
            $table->float('dew_point')->nullable();
            $table->float('et0')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};