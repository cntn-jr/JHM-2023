<?php

namespace Database\Factories;

use App\Const\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()
            ->whereIn('role', [Role::STUDENT, Role::TEACHER])
            ->get(['id']);
        return [
            'name' => fake()->company(),
            'homepage_url' => 'https://google.com',
            'job_hunting_app_url' => 'https://www.wantedly.com/projects',
            'user_id' => fake()->randomElement($users)->id,
            'head_office_location' => fake()->prefecture(),
            'note' => fake()->emoji(),
        ];
    }
}
