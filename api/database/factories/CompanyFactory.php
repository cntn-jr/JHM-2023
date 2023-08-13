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
        return [
            'name' => fake()->company(),
            'homepage_url' => 'https://google.com',
            'job_hunting_app_url' => 'https://www.wantedly.com/projects',
            'head_office_location' => fake()->prefecture(),
            'note' => fake()->emoji(),
        ];
    }

    /**
     * 作成者に教師を指定
     *
     * @return void
     */
    public function teacher() {
        $teachers = User::query()
            ->where('role', Role::TEACHER)
            ->get(['id']);
        return $this->state(fn (array $attributes) =>
            [ 'user_id' =>fake()->randomElement($teachers)->id, ]
        );
    }

    /**
     * 作成者に生徒を指定
     *
     * @return void
     */
    public function student() {
        $students = User::query()
            ->where('role', Role::STUDENT)
            ->get(['id']);
        return $this->state(fn (array $attributes) =>
            [ 'user_id' =>fake()->randomElement($students)->id, ]
        );
    }
}
