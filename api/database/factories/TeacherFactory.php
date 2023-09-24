<?php

namespace Database\Factories;

use App\Const\Role;
use App\Models\School;
use App\Repositories\SchoolRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schoolRepository = new SchoolRepository();
        $schools = $schoolRepository->findAll();
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'first_name_kana' => fake()->firstKanaName(),
            'last_name_kana' => fake()->lastKanaName(),
            'email' => fake()->unique()->userName() . '@kawahara.ac.jp',
            'password' => Hash::make('password'),
            'role' => Role::TEACHER,
            'school_id' => fake()->randomElement($schools)->id,
        ];
    }
}
