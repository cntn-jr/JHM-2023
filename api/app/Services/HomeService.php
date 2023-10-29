<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\EntryRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Auth;

class HomeService {

    public function __construct(
        readonly private ?EntryRepository   $entryRepository,
        readonly private ?StudentRepository $studentRepository
    )
    {}

    public function manager(): array
    {
        $loginManager = Auth::user();

        // 選考情報とともに該当学校の生徒情報を取得
        $students = $this->studentRepository->findScopedSchoolWithEntry($loginManager->school_id);

        // 選考中の生徒の生徒のみ取り出す
        $inSelectionStudents = $students->filter(function (Student $student) {
            return $student->is_selection;
        });

        // 内定取得済みの生徒のみ
        $passedStudents = $students->filter(function (Student $student) {
            return $student->is_passing;
        });

        // 内定取得した選考情報のみ取得
        $passedEntry = $this->entryRepository->findPassScopedSchool($loginManager->school_id);
        return [
            'students'            => $students,
            'inSelectionStudents' => $inSelectionStudents,
            'passedStudents'      => $passedStudents,
            'passedEntry'         => $passedEntry,
        ];
    }
}