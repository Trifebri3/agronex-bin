<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_data', function (Blueprint $table) {
            $table->id();

            $table->float('kelembapan')->nullable();
            $table->float('suhu')->nullable();
            $table->float('ec')->nullable();
            $table->float('ph')->nullable();
            $table->float('nitrogen')->nullable();
            $table->float('fosfor')->nullable();
            $table->float('kalium')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_data');
    }
};