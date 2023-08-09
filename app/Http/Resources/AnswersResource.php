<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Contracts\SurveyContract;
use App\Contracts\SurveyQuestionAnswerContract;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            SurveyQuestionAnswerContract::ID => $this->id,
            SurveyQuestionAnswerContract::ANSWER => $this->answer,
            SurveyQuestionAnswerContract::SURVEY => [
                SurveyContract::ID => $this->question->survey->id,
                SurveyContract::TITLE => $this->question->survey->title,
                SurveyQuestionAnswerContract::QUESTION => [
                    SurveyQuestionAnswerContract::ID => $this->question->id,
                    SurveyQuestionAnswerContract::QUESTION => $this->question->question,
                    SurveyQuestionAnswerContract::TYPE => $this->question->type->title(),
                ],
            ],
            SurveyQuestionAnswerContract::CREATED_AT => $this->created_at,
        ];
    }
}
