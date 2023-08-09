<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditSurveyQuestionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\QuestionType;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Contracts\SurveyQuestionContract;
use App\Http\Resources\SurveyQuestionResource;

class EditSurveyQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EditSurveyQuestionRequest $request)
    {
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }

        try {
            $question = $survey->questions()->findorfail($request->route('question_id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No question found with the provided ID on this survey", Response::HTTP_NOT_FOUND);
        }
        $validatedInput = $request->validated();
        $request->input('question') ? $question->question = $validatedInput[SurveyQuestionContract::QUESTION] : null;
        $request->input('type') ? $question->type = QuestionType::tryFrom($validatedInput[SurveyQuestionContract::TYPE])->value : null;
        $question->save();
        return new SurveyQuestionResource($question, Response::HTTP_OK);
    }
}
