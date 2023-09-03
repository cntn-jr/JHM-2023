<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository {
    public function findAllScopedSchool(int $school_id)
    {
        return Teacher::query()
            ->school($school_id)
            ->get();
    }
}