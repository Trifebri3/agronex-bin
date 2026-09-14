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
        Schema::create('irrigation_commands', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->string('command'); // PUMP_ON, PUMP_OFF
            $table->string('status')->default('PENDING'); // PENDING, EXECUTED
            $table->timestamps();
            
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigation_commands');
    }
};
