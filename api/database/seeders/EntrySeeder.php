<?php

namespace Database\Seeders;

use App\Const\EntryResult;
use App\Models\Entry;
use App\Repositories\CompanyRepository;
use App\Repositories\EntryRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\StudentRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyRepository = new CompanyRepository();
        $entryRepository   = new EntryRepository();
        $schoolRepository  = new SchoolRepository();
        $studentRepository = new StudentRepository($entryRepository);
        $schools = $schoolRepository->findAll();
        foreach ($schools as $school) {
            $students = $studentRepository->findScopedSchool($school->id);

            // ５％の確率を引いた生徒以外はどこかしらの企業に応募している
            foreach ($students as $student) {
                if (fake()->boolean(5)) continue;
                $companyNum = fake()->numberBetween(1, 8);
                $companies = fake()->randomElements(
                    $companyRepository->findScopedSchool($school->id),
                    $companyNum
                );
                foreach ($companies as $company) {
                    $result = fake()->randomElement(EntryResult::ALL);
                    $passedDatetime = fake()->dateTimeBetween('2023-05-01', '2023-12-20');
                    $passedDate = $passedDatetime->format('Y-m-d');
                    Entry::factory()->create([
                        'student_id'  => $student->id,
                        'company_id'  => $company->id,
                        'result'      => $result,
                        'passed_date' => $result == EntryResult::PASSING ? $passedDate : null,
                    ]);
                }

                // 応募フラグの切り替え
                $studentRepository->proceedEntryFlg($student->id);
            }
        }
    }
}
