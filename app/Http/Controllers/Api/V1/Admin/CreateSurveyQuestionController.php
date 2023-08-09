<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSurveyQuestionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\QuestionType;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Contracts\SurveyQuestionContract;
use App\Http\Resources\SurveyQuestionResource;

class CreateSurveyQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateSurveyQuestionRequest $request)
    { 
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }
        $validatedInput = $request->validated();
        $question = new SurveyQuestion;
        $question->question = $validatedInput[SurveyQuestionContract::QUESTION];
        $question->type = QuestionType::tryFrom($validatedInput[SurveyQuestionContract::TYPE])->value;
        $question->survey_id = $survey->id;
        $question->save();
        return new SurveyQuestionResource($question, Response::HTTP_CREATED);
    }
}
