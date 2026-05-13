<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => '管理员',
            'email' => 'admin@lottery.com',
            'password' => bcrypt('admin123456'),
        ]);

        \App\Models\HomepageSection::insert([
            ['section_key'=>'draw',    'title'=>'开奖结果',  'is_enabled'=>1, 'sort_order'=>10, 'display_limit'=>null, 'created_at'=>now(), 'updated_at'=>now()],
            ['section_key'=>'posts',   'title'=>'最新帖子',  'is_enabled'=>1, 'sort_order'=>20, 'display_limit'=>6,    'created_at'=>now(), 'updated_at'=>now()],
            ['section_key'=>'gallery', 'title'=>'图片展示',  'is_enabled'=>1, 'sort_order'=>30, 'display_limit'=>8,    'created_at'=>now(), 'updated_at'=>now()],
        ]);

        \App\Models\DrawSchedule::insert([
            ['type'=>'store',  'type_label'=>'店内开奖', 'default_weekdays'=>'1,3,5', 'default_time'=>'21:30:00', 'created_at'=>now(), 'updated_at'=>now()],
            ['type'=>'online', 'type_label'=>'线上开奖', 'default_weekdays'=>'2,4,6', 'default_time'=>'21:00:00', 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
