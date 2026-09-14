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
        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // water, fertilizer, check, etc.
            $table->string('priority')->default('normal'); // high, normal, low
            $table->string('time_suggestion')->nullable(); // e.g. "08.00 WIB", "Sebelum sore"
            $table->boolean('is_completed')->default(false);
            $table->date('plan_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_plans');
    }
};
