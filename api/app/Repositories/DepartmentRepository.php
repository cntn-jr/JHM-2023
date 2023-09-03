<?php
namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository {
    /**
     * 指定した学校の学科を取得する
     *
     * @param integer $school_id
     * @return array
     */
    public function findScopedSchool(int $school_id)
    {
        return Department::query()
            ->school($school_id)
            ->get();
    }
}