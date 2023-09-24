<?php

namespace Database\Seeders;

use App\Const\SelectionStatus;
use App\Models\ActivityStatus;
use App\Repositories\EntryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entryRepository = new EntryRepository();
        $entries = $entryRepository->findAll();
        foreach ($entries as $entry) {
            $selectionMin = 1;
            $selectionMax = 5;
            $randomStatusNum = fake()->numberBetween($selectionMin, $selectionMax);
            $activityStatues = fake()->randomElements(SelectionStatus::ALL, $randomStatusNum);
            foreach ($activityStatues as $activityStatus) {
                ActivityStatus::factory()->create([
                    'entry_id'      => $entry->id,
                    'status_number' => $activityStatus,
                ]);
            }
        }
    }
}
