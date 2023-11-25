<?php

namespace App\Http\Requests\manager;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends BaseRequest
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
        $emailValidation = [
            'required',
            'email',
            Rule::unique('users')->ignore($this->input('teacher_id')),
        ];
        return [
            'teacher_id'            => 'is_teacher',
            'first_name'            => 'required|string|max:63',
            'last_name'             => 'required|string|max:63',
            'first_name_kana'       => 'required|hiragana|max:127',
            'last_name_kana'        => 'required|hiragana|max:127',
            'email'                 => $emailValidation,
            'password'              => 'required|password|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}
