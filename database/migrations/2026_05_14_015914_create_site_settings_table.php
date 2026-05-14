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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('site_settings')->insert([
            ['key' => 'marquee_text', 'label' => '跑马灯公告', 'value' => '欢迎来到马来西亚六合彩开奖信息平台 · 公正 · 透明 · 及时 · 祝您好运！', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
