<?php

namespace App\Http\Requests;

use App\Const\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateTeacherRequest extends FormRequest
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
            'first_name'            => 'required|string|max:63',
            'last_name'             => 'required|string|max:63',
            'first_name_kana'       => 'required|hiragana|max:127',
            'last_name_kana'        => 'required|hiragana|max:127',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|password|confirmed',
            'password_confirmation' => 'required',
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
            'first_name'            => '名',
            'last_name'             => '姓',
            'first_name_kana'       => 'めい',
            'last_name_kana'        => 'せい',
            'email'                 => 'メールアドレス',
            'password'              => 'パスワード',
            'password_confirmation' => '確認用パスワード',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'first_name.required'      => ':attributeは必須項目です。',
            'first_name.string'        => ':attributeに使用できない文字列が含まれています。',
            'first_name.max'           => ':attributeは63文字までです。',
            'last_name.required'       => ':attributeは必須項目です。',
            'last_name.string'         => ':attributeに使用できない文字列が含まれています。',
            'last_name.max'            => ':attributeは63文字までです。',
            'first_name_kana.required' => ':attributeは必須項目です。',
            'first_name_kana.hiragana' => ':attributeの形式が正しくありません。',
            'first_name_kana.max'      => ':attributeは127文字までです。',
            'last_name_kana.required'  => ':attributeは必須項目です。',
            'last_name_kana.hiragana'  => ':attributeの形式が正しくありません。',
            'last_name_kana.max'       => ':attributeは127文字までです。',
            'email.required'           => ':attributeは必須項目です。',
            'email.email'              => ':attributeの形式が正しくありません。',
            'email.unique'             => ':attributeは既に使用されています。',
            'password.required'        => ':attributeは必須項目です。',
            'password.password'        => ':attributeはアルファベットの大文字・小文字、数字をそれぞれ１文字以上を必要とし、８〜３２文字です。',
            'password.confirmed'       => 'パスワードが一致しません',
        ];
    }
}
