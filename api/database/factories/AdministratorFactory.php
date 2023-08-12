<?php

namespace Database\Factories;

use App\Const\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrator>
 */
class AdministratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->userName() . '@admin.kawahara.ac.jp',
            'password' => Hash::make('password'),
            'role' => Role::ADMINISTRATOR,
        ];
    }
}
