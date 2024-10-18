<?php

namespace Database\Seeders;

use App\Models\SystemAdmin;
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
        foreach (range(1, 10) as $index) {
            SystemAdmin::create([
                'username' => $index == 1 ? 'admin' : Str::random(6),
                'com_id'   => 1,
                'email'    => 'xxxx' . $index . '@gmail.com',
                'password' => bcrypt('123456'),
                'avatar'   => 'avatar.png'
            ]);
        }
    }
}
