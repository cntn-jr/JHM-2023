<?php

namespace App\Services;

use App\Facades\CsvHandler;
use App\Http\Requests\manager\CreateTeacherRequest;
use App\Http\Requests\manager\DestroyTeacherRequest;
use App\Http\Requests\manager\UpdateTeacherRequest;
use App\Http\Requests\manager\UploadTeacherCsvRequest;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use App\Rules\UniqueInArray;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lang;

class TeacherService {

    const CSV_HEADER = [
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'email',
        'password',
    ];

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

        // 管理下の教師かどうか確認する
        $teacher = $this->teacherRepository->findById($columns['teacher_id']);

        // 管理下の教師かどうか確認する
        if ($this->isManagedTeacher($teacher)) {

            // 教師情報を更新する
            $result = $this->teacherRepository->updateAccount($teacher, $columns);
            return [
                'result' => $result,
            ];
        }
        return [
            'result'  => false,
            'message' => 'Not a supervised teacher.',
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

        // 指定された教師を取得する
        $teacherId = $request->input('teacher_id');
        $teacher = $this->teacherRepository->findById($teacherId);

        // 管理下の教師かどうか確認する
        if ($this->isManagedTeacher($teacher)) {

            // 教師アカウントを削除する
            $result = $this->teacherRepository->deleteAccount($teacher);
            return [
                'result' => $result,
            ];
        }

        return [
            'result'  => false,
            'message' => 'Not a supervised teacher.',
        ];
    }

    /**
     * CSVファイルから取得したデータをバリデーションし返す
     *
     * @param UploadTeacherCsvRequest $request
     * @return array
     */
    public function uploadCsv(UploadTeacherCsvRequest $request): array
    {

        // ファイル形式を確認する
        $requestCsvFile = $request->file('teacher_csv');
        if (!CsvHandler::isCsvExtension($requestCsvFile)) {
            return [
                'result'  => false,
                'message' => 'File extension is invalid.',
            ];
        }

        // ファイルを保存
        $filePath = CsvHandler::save($requestCsvFile);

        // ファイルの保存に失敗
        if (!$filePath) {
            return [
                'result'  => false,
                'message' => 'Failed to save the CSV file.',
            ];
        }

        // ファイル内容を取得する
        $contents = CsvHandler::getContents($filePath, self::CSV_HEADER);

        // バリデーションを実行
        $validatedContents = $this->validateTeachers($contents);

        // 一時ファイルの削除
        CsvHandler::remove($filePath);

        return [
            'result'  => true,
            'message' => '',
            'data'    => $validatedContents,
        ];
    }

    /**
     * 管理下の教師かどうかを判定する
     *
     * @param Teacher $teacher
     * @return boolean
     */
    private function isManagedTeacher(Teacher $teacher): bool
    {
        $loginManager = Auth::user();
        return $loginManager->school_id == $teacher->school_id;
    }

    /**
     * CSVデータが教師情報のバリデーションにかける
     *
     * @param array $teachers
     * @return array
     */
    private function validateTeachers(array $teachers): array
    {

        // データが100件を超える場合データ挿入を中止する
        if (count($teachers) > 100) {
            return [];
        }

        // 行ごとにバリデーションを実行する
        $validatedContents = array();
        $emails = array();
        foreach ($teachers as $teacher) {
            $rowData = array(
                'data'   => [],
                'errors' => [],
            );

            // メールアドレスのバリデーションを予め設定
            $emailValidation = [
                'required',
                'email',
                'unique:users,email',
                new UniqueInArray(
                    $emails,
                    Lang::get('validation.unique_in_csv')
                ),
            ];

            // バリデーションを実行
            $validator = Validator::make($teacher, [
                'first_name'      => 'required|string|max:63',
                'last_name'       => 'required|string|max:63',
                'first_name_kana' => 'required|hiragana|max:127',
                'last_name_kana'  => 'required|hiragana|max:127',
                'email'           => $emailValidation,
                'password'        => 'required|max:32|password',
            ]);

            // エラーメッセージを挿入する
            if ($validator->fails()) {
                $rowData['errors'] = $validator->errors();
            }

            // バリデーション済みのデータを挿入する
            $rowData['data'] = $validator->getData();
            $validatedContents[] = $rowData;

            // CSV中のユニーク制限のため
            isset($teacher['email']) && $emails[] = $teacher['email'];
        }
        return $validatedContents;
    }
}