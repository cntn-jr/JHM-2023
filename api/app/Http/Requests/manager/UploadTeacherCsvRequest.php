<?php

namespace App\Http\Requests\manager;

use App\Http\Requests\BaseRequest;

class UploadTeacherCsvRequest extends BaseRequest
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
            'teacher_csv' => 'required|file',
        ];
    }
}
