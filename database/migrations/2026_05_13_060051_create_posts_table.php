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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('cover_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->string('tag')->nullable()->comment('置顶|公告 等标签');
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['is_published', 'is_pinned', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
