<?php

namespace App\Repositories;

use App\Models\Teacher;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TeacherRepository {

    /**
     * 教師の全情報を取得する
     *
     * @return Collection
     */
    public function findAll() :Collection
    {
        return Teacher::all();
    }

    /**
     * 指定した学校の教師情報を取得する
     *
     * @param integer $school_id
     * @return Collection
     */
    public function findScopedSchool(int $school_id): Collection
    {
        return Teacher::query()
            ->school($school_id)
            ->get();
    }

    /**
     * 学校情報を基に教師情報とそれに紐づく学科情報を取得する
     *
     * @param integer $school_id
     * @return Collection
     */
    public function findScopedSchoolWithDepartment(int $school_id): Collection
    {
        return Teacher::query()
            ->school($school_id)
            ->with('departments')
            ->get();
    }

    /**
     * 教師アカウントを作成する
     *
     * @param array $teacherColumns
     * @return void
     */
    public function createAccount(array $teacherColumns): Teacher | false
    {
        $teacher = Teacher::create($teacherColumns);
        return $teacher;
    }
}