<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Contracts\SurveyContract;
use App\Contracts\SurveyQuestionContract;

class SurveyQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            SurveyQuestionContract::ID => $this->id,
            SurveyQuestionContract::QUESTION => $this->question,
            SurveyQuestionContract::TYPE => $this->type->title(),
            SurveyQuestionContract::SURVEY => [
                SurveyContract::ID => $this->survey->id,
                SurveyContract::TITLE => $this->survey->title,
            ],
            SurveyQuestionContract::CREATED_AT => $this->created_at,
        ];
    }
}
