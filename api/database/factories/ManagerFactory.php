<?php

namespace Database\Factories;

use App\Const\Role;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schools = School::all(['id']);
        return [
            'email' => fake()->unique()->userName() . '@manager.kawahara.ac.jp',
            'password' => Hash::make('password'),
            'role' => Role::MANAGER,
            'school_id' => fake()->randomElement($schools)->id,
        ];
    }
}
