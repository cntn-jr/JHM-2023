<?php

namespace Database\Seeders;

use App\Models\SelectionSchedule;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SelectionScheduleSeeder extends Seeder
{

    const SCHEDULES_TITLE = [
        '応募締め切り',
        '書類提出締め切り',
        '１次面接予定',
        '２次面接予定',
        '最終面接予定',
        '説明会',
        'オンライン説明会',
        'カジュアル面談',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyRepository = new CompanyRepository();
        $companies = $companyRepository->findAll();
        foreach ($companies as $company) {
            if (fake()->boolean(60)) {
                $scheduleTitles = fake()->randomElements(self::SCHEDULES_TITLE, 3);
                foreach ($scheduleTitles as $scheduleTitle) {
                    SelectionSchedule::factory()->create([
                        'title'      => $scheduleTitle,
                        'company_id' => $company->id,
                    ]);
                }
            }
        }
    }
}
