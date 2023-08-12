<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schoolNames = [
            fake()->lastName() . 'コンピューター専門学校',
            fake()->prefecture() . '大学',
            fake()->ward() . '大学',
        ];
        return [
            'name' => fake()->randomElement($schoolNames),
        ];
    }
}
