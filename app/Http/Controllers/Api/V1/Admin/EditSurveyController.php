<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditSurveyRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Contracts\SurveyContract;
use App\Http\Resources\SurveyResource;

class EditSurveyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EditSurveyRequest $request)
    {
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }

        $validatedInput = $request->validated();
        $request->input('title') ? $survey->title = $validatedInput[SurveyContract::TITLE] : null;
        $request->input('expires_at') ? $survey->expires_at = $validatedInput[SurveyContract::EXPIRES_AT] : null;
        $survey->save();

        return new SurveyResource($survey,Response::HTTP_OK);
    }
}
