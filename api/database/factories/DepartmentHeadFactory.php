<?php

namespace Database\Factories;

use App\Models\Department;
use App\Repositories\TeacherRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepartmentHead>
 */
class DepartmentHeadFactory extends Factory
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
     * 学科情報から教師をランダムに指定し、学科長情報を作成する
     *
     * @return Factory
     */
    public function createByDepartment(): Factory
    {
        return $this->state(function (array $attributes, Department $department) {
            $teacherRepository = new TeacherRepository();
            $school_id = $department->school_id;
            $teachers = $teacherRepository->findAllScopedSchool($school_id);
            return [
                'department_id' => $department->id,
                'teacher_id' => fake()->randomElement($teachers)->id,
            ];
        });
    }

}
