<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Manager;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::factory(3)
            ->has(
                Manager::factory()
                ->state(function (array $attributes, School $school) {
                    return [ 'school_id' => $school->id, ];
                })
            )
            ->has(
                Teacher::factory(10)
                    ->has(
                        Company::factory(5)
                            ->state(function (array $attributes, Teacher $teacher) {
                                return [ 'user_id' => $teacher->id, ];
                            })
                    )
                    ->state(function (array $attributes, School $school) {
                        return [ 'school_id' => $school->id, ];
                    })
            )
            ->has(
                Student::factory(30)
                    ->has(
                        Company::factory(3)
                            ->state(function (array $attributes, Student $student) {
                                return [ 'user_id' => $student->id, ];
                            })
                    )
                    ->state(function (array $attributes, School $school) {
                        return [ 'school_id' => $school->id, ];
                    })
            )
            ->create();
    }
}
