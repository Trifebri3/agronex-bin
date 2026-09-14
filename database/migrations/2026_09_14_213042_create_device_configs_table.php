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
        Schema::create('device_configs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique(); // foreign key references devices(device_id)
            $table->string('mode')->default('AUTO_SENSOR'); // AUTO_SENSOR, AUTO_TARGET, MANUAL
            $table->float('threshold_on')->default(35);
            $table->float('threshold_off')->default(50);
            $table->float('target_moisture')->default(60);
            $table->integer('max_watering_duration')->default(300); // 5 mins
            $table->integer('cooldown_minutes')->default(10);
            $table->timestamps();
            
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_configs');
    }
};
