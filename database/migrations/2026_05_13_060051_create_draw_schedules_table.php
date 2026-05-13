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
        Schema::create('draw_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string('type_label');
            $table->string('default_weekdays')->nullable()->comment('逗号分隔，如 1,3,5');
            $table->time('default_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draw_schedules');
    }
};
