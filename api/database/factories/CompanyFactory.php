<?php

namespace Database\Factories;

use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
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
     * @param integer $schoolId
     * @return Factory
     */
    public function teacher(int $schoolId) :Factory
    {
        $teacherRepository = new TeacherRepository();
        $teachers = $teacherRepository->findScopedSchool($schoolId);
        return $this->state(function (array $attributes) use ($teachers) {
            $teacher = fake()->randomElement($teachers);
            return [
                'user_id'   => $teacher->id,
                'school_id' => $teacher->school_id,
            ];
        });
    }

    /**
     * 作成者に生徒を指定
     *
     * @param integer $schoolId
     * @return Factory
     */
    public function student(int $schoolId) :Factory
    {
        $studentRepository = new StudentRepository();
        $students = $studentRepository->findScopedSchool($schoolId);
        return $this->state(function (array $attributes) use ($students) {
            $student = fake()->randomElement($students);
            return [
                'user_id'   => $student->id,
                'school_id' => $student->school_id,
            ];
        });
    }
}
