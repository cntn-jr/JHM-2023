<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository {
    public function findAllScopedSchool(int $school_id)
    {
        return Teacher::query()
            ->role()
            ->where('school_id', $school_id)
            ->get();
    }
}