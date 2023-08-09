<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\QuestionType;
use App\Contracts\SurveyQuestionContract;

class CreateSurveyQuestionRequest extends FormRequest
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
            SurveyQuestionContract::QUESTION => ['required','string'],
            SurveyQuestionContract::TYPE => ['required','integer', new Enum(QuestionType::class), 'max:3'],
        ];
    }
}
