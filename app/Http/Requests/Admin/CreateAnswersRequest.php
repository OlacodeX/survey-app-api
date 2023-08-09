<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Contracts\SurveyQuestionAnswerContract;

class CreateAnswersRequest extends FormRequest
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
            SurveyQuestionAnswerContract::ANSWER => ['required', 'array'],
            // 'answer[0]'.'*.'.TaskContract::INSTRUCTIONS => ['required', 'array'],
        ];
    }
}
