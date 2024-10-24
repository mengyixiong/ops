<?php

namespace Database\Factories;

use App\Models\SystemAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<SystemAdmin>
 */
class SystemAdminFactory extends Factory
{
    protected $model = SystemAdmin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'is_super_admin' => 'N',
            'nickname'       => $faker->name(),
            'username'       => $faker->userName(),
            'current_com_id' => 1,
            'email'          => $faker->email(),
            'password'       => bcrypt('123456'),
            'avatar'         => '/default.png',
            'created_by'     => 1,
            'updated_by'     => 1,
        ];
    }
}
