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
        Schema::create('irrigation_events', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->string('trigger_type'); // MANUAL, AUTO
            $table->float('moisture_before')->nullable();
            $table->float('moisture_after')->nullable();
            $table->timestamp('pump_started_at')->nullable();
            $table->timestamp('pump_stopped_at')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->string('status')->default('completed'); // completed, interrupted
            $table->timestamps();
            
            $table->foreign('device_id')->references('device_id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigation_events');
    }
};
