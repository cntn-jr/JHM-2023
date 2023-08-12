<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'first_name_kana' => fake()->firstKanaName(),
            'last_name' => fake()->lastKanaName(),
            'email' => fake()->userName() . '@stu.kawahara.ac.jp',
            'password' => Hash::make('password'),
            'role' => Role::STUDENT,
            'school_id' => fake()->randomElement($schools)->id,
        ];
    }
}
