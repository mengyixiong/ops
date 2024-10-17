<?php

namespace Database\Seeders;

use App\Models\SystemCompany;
use Illuminate\Database\Seeder;

class SystemCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemCompany::create([
            'name' =>'深圳市大黄瓜有限公司',
            'abb'    => '大黄瓜',
        ]);
    }
}
