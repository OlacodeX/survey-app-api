<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSurveyRequest;
use App\Models\Survey;
use App\Contracts\SurveyContract;
use App\Http\Resources\SurveyResource;

class CreateSurveyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateSurveyRequest $request)
    {
        $validatedInput = $request->validated();
        $survey = new Survey;
        $survey->title = $validatedInput[SurveyContract::TITLE];
        $survey->created_by = Auth::user()->id;
        $survey->expires_at = $validatedInput[SurveyContract::EXPIRES_AT];
        $survey->save();

        return new SurveyResource($survey);
    }
}
