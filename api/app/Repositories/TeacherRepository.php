<?php

namespace App\Repositories;

use App\Models\Teacher;
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
    public function findScopedSchool(int $school_id) :Collection
    {
        return Teacher::query()
            ->school($school_id)
            ->get();
    }
}