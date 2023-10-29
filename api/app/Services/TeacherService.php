<?php

namespace App\Services;

use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Auth;

class TeacherService {

    public function __construct(readonly private ?TeacherRepository $teacherRepository)
    {}

    public function index()
    {
        $loginManager = Auth::user();

        // 該当学校の教師情報を学科情報とともに取得する
        $teachers = $this->teacherRepository->findScopedSchoolWithDepartment($loginManager->school_id);
        return [
            'teachers' => $teachers,
        ];
    }
}