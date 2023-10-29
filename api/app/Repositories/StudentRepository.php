<?php
    namespace App\Repositories;

use App\Const\EntryResult;
use App\Models\Entry;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

    class StudentRepository {

        public function __construct(readonly private ?EntryRepository $entryRepository = null)
        {}

        /**
         * 生徒の全情報を取得する
         *
         * @return Collection
         */
        public function findAll(): Collection
        {
            return Student::all();
        }

        /**
         * 指定学校の全生徒を取得
         *
         * @param integer $schoolId
         * @return Collection
         */
        public function findScopedSchool(int $schoolId): Collection
        {
            return Student::query()
                ->school($schoolId)
                ->get();
        }

        /**
         * 指定学校の全生徒を応募情報とともに取得
         *
         * @param integer $schoolId
         * @return Collection
         */
        public function findScopedSchoolWithEntry(int $schoolId): Collection
        {
            return Student::query()
                ->school($schoolId)
                ->with('entries')
                ->get();
        }

        /**
         * 必要であれば生徒の応募関連フラグを切り替える
         *
         * @param integer $studentId
         * @return boolean
         */
        public function proceedEntryFlg(int $studentId): bool
        {
            $entries = $this->entryRepository->findScopedStudent($studentId);
            if (is_null($entries)) {
                return true;
            }
            $student = Student::find($studentId);

            // 応募情報から選考フラグを切り替える
            $student->is_selection = $entries->contains(function (Entry $entry) {
                return $entry->result == EntryResult::IN_SELECTION;
            });

            // 応募情報から内定フラグを切り替える
            $student->is_passing = $entries->contains(function (Entry $entry) {
                return $entry->result == EntryResult::PASSING;
            });
            return $student->save();
        }
    }