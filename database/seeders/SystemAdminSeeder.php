<?php

namespace Database\Seeders;

use App\Models\SystemAdmin;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemAdmin::create([
            'is_super_admin' => 'Y',
            'nickname'       => '超级管理员',
            'username'       => 'admin',
            'current_com_id' => 1,
            'email'          => 'qq1450603827@qq.com',
            'password'       => bcrypt('123456'),
            'avatar'         => '/default.png',
            'created_by'     => 1,
            'updated_by'     => 1,
        ]);
        SystemAdmin::factory()->count(20)->create();
    }
}
