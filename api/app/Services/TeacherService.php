<?php

namespace App\Services;

use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\DestroyTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Auth;

class TeacherService {

    public function __construct(readonly private ?TeacherRepository $teacherRepository)
    {}

    /**
     * 教師一覧情報を取得する
     *
     * @return array
     */
    public function index(): array
    {
        $loginManager = Auth::user();

        // 該当学校の教師情報を学科情報とともに取得する
        $teachers = $this->teacherRepository->findScopedSchoolWithDepartment($loginManager->school_id);
        return [
            'teachers' => $teachers,
        ];
    }

    /**
     * 教師アカウントを作成する
     *
     * @param CreateTeacherRequest $request
     * @return Teacher
     */
    public function createAccount(CreateTeacherRequest $request): Teacher
    {
        $loginManager = Auth::user();

        // 教師アカウント作成に必要な入力値を抽出
        $columns = $request->only([
            'first_name',
            'last_name',
            'first_name_kana',
            'last_name_kana',
            'email',
            'password',
        ]);

        // リクエスト以外の必要な値を付与
        $columns['school_id'] = $loginManager->school_id;

        // 教師アカウント作成
        return $this->teacherRepository->createAccount($columns);
    }

    /**
     * 作成教師アカウントの確認
     *
     * @param CreateTeacherRequest $request
     * @return array
     */
    public function confirm(CreateTeacherRequest $request): array
    {
        // バリデーションチェックに通ったらそのまま入力値を返す
        return $request->only([
            'first_name',
            'last_name',
            'first_name_kana',
            'last_name_kana',
            'email',
            'password',
        ]);
    }

    /**
     * 教師アカウントを更新する
     *
     * @param UpdateTeacherRequest $request
     * @return array
     */
    public function updateAccount(UpdateTeacherRequest $request): array
    {
        // 教師アカウント作成に必要な入力値を抽出
        $columns = $request->only([
            'teacher_id',
            'first_name',
            'last_name',
            'first_name_kana',
            'last_name_kana',
            'email',
            'password',
        ]);

        // 教師情報を更新する
        $result = $this->teacherRepository->updateAccount($columns);
        return [
            'result' => $result,
        ];
    }

    /**
     * 教師アカウントを削除する
     *
     * @param DestroyTeacherRequest $request
     * @return array
     */
    public function deleteAccount(DestroyTeacherRequest $request): array
    {
        $teacherId = $request->input('teacher_id');

        // 教師アカウントを削除する
        $result = (bool)$this->teacherRepository->deleteAccount($teacherId);
        return [
            'result' => $result,
        ];
    }
}