<?php

namespace Database\Factories;

use App\Models\Student;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnrollmentClass>
 */
class EnrollmentClassFactory extends Factory
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

    /**
     * 生徒情報から生徒在籍情報を作成する
     *
     * @return Factory
     */
    public function createByStudent(): Factory
    {
        return $this->state(function (array $attributes, Student $student) {
            $school_id = $student->school_id;
            $departmentRepository = new DepartmentRepository();
            $departments = $departmentRepository->findScopedSchool($school_id);
            return [
                'department_id' => fake()->randomElement($departments)->id,
                'student_id'    => $student->id,
            ];
        });
    }
}
