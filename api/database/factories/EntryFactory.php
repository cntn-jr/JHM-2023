<?php

namespace Database\Factories;

use App\Repositories\StudentRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function createBySchool(int $schoolId): Factory
    {
        $studentRepository = new StudentRepository();
        $students = $studentRepository->findScopedSchool($schoolId);
        if (fake()->boolean(80)) {
            return $this->state(function () use ($students) {
                $entryNum = fake()->numberBetween(1, 8);
                $students = fake()->randomElements($students, $entryNum);
                return [];
            });
        }
    }
}
