<?php
    namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

    class StudentRepository {

        /**
         * 生徒の全情報を取得する
         *
         * @return Collection
         */
        public function findAll(): Collection
        {
            return Student::all();
        }

        public function findScopedSchool(int $school_id): Collection
        {
            return Student::query()
                ->school($school_id)
                ->get();
        }
    }