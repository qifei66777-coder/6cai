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
        Schema::create('draw_results', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('store');
            $table->string('issue_number');
            $table->date('draw_date');
            $table->time('draw_time');
            $table->tinyInteger('weekday')->nullable();
            $table->string('status')->default('pending');
            $table->string('special_number')->nullable();
            $table->string('special_color')->default('red');
            $table->string('special_label')->nullable();
            $table->string('video_file')->nullable();
            $table->string('video_url')->nullable();
            $table->string('history_url')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_home_featured')->default(false);
            $table->timestamps();
            $table->index(['type', 'is_home_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draw_results');
    }
};
