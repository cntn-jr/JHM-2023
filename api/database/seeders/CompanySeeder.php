<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Repositories\SchoolRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schoolRepository = new SchoolRepository();
        $schools = $schoolRepository->findAll();
        foreach ($schools as $school) {
            Company::factory(40)->teacher($school->id)->create();
            Company::factory(15)->student($school->id)->create();
        }
    }
}
