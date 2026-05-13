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
        Schema::create('draw_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_result_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->string('color')->default('blue');
            $table->string('label')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['draw_result_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draw_numbers');
    }
};
