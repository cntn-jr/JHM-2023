<?php

namespace App\Http\Requests;

use App\Const\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class DestroyTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_id' => 'isTeacher',
        ];
    }

    /**
     * バリデーションに失敗した場合の処理
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->ApiFailed(
            message   : 'Validation of teacher data failed.',
            contents  : $validator->errors(),
            statusCode: 400,
        );

        throw new HttpResponseException($response);
    }

    /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'teacher_id' => '教師ID',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'teacher_id.is_teacher' => '存在しない教師IDが指定されています。',
        ];
    }
}
