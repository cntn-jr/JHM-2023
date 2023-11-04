<?php

namespace App\Services;

use App\Http\Requests\CreateTeacherRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function createAccount(CreateTeacherRequest $request)
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

        Log::debug($columns);

        // 教師アカウント作成
        return $this->teacherRepository->createAccount($columns);
    }

    public function confirm(CreateTeacherRequest $request)
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
}