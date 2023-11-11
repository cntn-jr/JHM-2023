<?php

namespace App\Repositories;

use App\Models\Teacher;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class TeacherRepository {

    /**
     * IDから教師情報を取得する
     *
     * @param integer $teacherId
     * @return Teacher
     */
    public function findById(int $teacherId) :Teacher
    {
        try {
            return Teacher::query()->findOrFail($teacherId);
        } catch (ModelNotFoundException $e) {
            throw new Exception("this teacher-id not exist.", 404);
        } catch (Exception $e) {
            throw new Exception();
        }
    }

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
     * @return Teacher
     */
    public function createAccount(array $teacherColumns): Teacher
    {
        $teacher = Teacher::query()->create($teacherColumns);
        return $teacher;
    }

    /**
     * 教師アカウントを更新する
     *
     * @param Teacher $teacher
     * @param array $teacherColumns
     * @return boolean
     */
    public function updateAccount(Teacher $teacher, array $teacherColumns): bool
    {
        // 教師情報を更新する
        $teacher->first_name      = $teacherColumns['first_name'];
        $teacher->last_name       = $teacherColumns['last_name'];
        $teacher->first_name_kana = $teacherColumns['first_name_kana'];
        $teacher->last_name_kana  = $teacherColumns['last_name_kana'];
        $teacher->email           = $teacherColumns['email'];
        $teacher->password        = $teacherColumns['password'];
        return $teacher->save();
    }

    /**
     * 教師アカウントを論理削除する
     *
     * @param Teacher $teacher
     * @return void
     */
    public function deleteAccount(Teacher $teacher): bool | null
    {
        return $teacher->delete();
    }
}