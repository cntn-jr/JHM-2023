<?php

namespace App\Repositories;

use App\Const\EntryResult;
use App\Models\Entry;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class EntryRepository {

    /**
     * 全ての応募情報を取得する
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Entry::all();
    }

    /**
     * 指定生徒の応募情報を取得する
     *
     * @param integer $studentId
     * @return Collection
     */
    public function findScopedStudent(int $studentId): Collection
    {
        return Entry::query()
            ->student($studentId)
            ->get();
    }

    /**
     * 内定済みの選考情報を取得する
     *
     * @param integer $schoolId
     * @return Collection
     */
    public function findPassScopedSchool(int $schoolId): Collection
    {
        $studentIds = Student::query()
            ->school($schoolId)
            ->get('id')
            ->toArray();
        $studentIds = array_column($studentIds, 'id');
        return Entry::query()
            ->result(EntryResult::PASSING)
            ->whereIn('student_id', $studentIds)
            ->orderBy('passed_date')
            ->get();
    }
}