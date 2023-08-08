<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Contracts\SurveyContract;
use App\Contracts\UserContract;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        return [
            SurveyContract::ID => $this->id,
            SurveyContract::TITLE => $this->title,
            SurveyContract::SLUG => $this->slug,
            SurveyContract::CREATOR => [
                UserContract::NAME => $this->creator?->name,
                UserContract::EMAIL => $this->creator?->email,
            ],
            SurveyContract::EXPIRES_AT => $this->expires_at,
            SurveyContract::CREATED_AT => $this->created_at,
        ];
    }
}
