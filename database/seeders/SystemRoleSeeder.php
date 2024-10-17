<?php

namespace Database\Seeders;

use App\Models\SystemRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => '超级管理员',
                'code' => 'ADMIN',
                'description' => 'Administrator',
            ],
            [
                'name' => '仓库管理员',
                'code' => 'WAREHOUSEMAN',
                'description' => '仓库管理员',
            ],
            [
                'name' => '应收财务',
                'code' => 'FINANCE_RECEIVABLE',
                'description' => '管理收款',
            ],
            [
                'name' => '应付财务',
                'code' => 'PAYABLE_FINANCE',
                'description' => '管理付款',
            ],
            [
                'name' => '前台',
                'code' => 'FOREGROUND',
                'description' => '客户接待，新人安排',
            ]
        ];

        foreach ($roles as $role) {
            SystemRole::create($role);
        }
    }
}
