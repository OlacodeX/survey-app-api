<?php

namespace App\Http\Requests\Admin;

use App\Contracts\SurveyContract;
use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            SurveyContract::TITLE => ['required','string'],
            SurveyContract::EXPIRES_AT => ['required','date'],
        ];
    }
}
