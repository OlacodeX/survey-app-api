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
     * @group Admin
     * 
     * Add question to a survey.
     *
     * This endpoint allows an admin to add question(s) to a survey
     * @bodyParam question string required The question of the survey. Example: My Question
     * @bodyParam type string required The question type which can either be 0 - text, 1 - single_choice, 2 - multiple_choice and 3 - number. Example: 0
     * @response 201 {
     *  "id": d346fd9f-a86a-47e5-ba30-b3d25e69bfd4,
     *  "question": "Question One",
     *  "type": "Text",
     *  "survey": {
     *      "id":"99d88e74-00ce-4ad8-80c9-b53d4cc0bf01",
     *       "title": "Title one"
     * },
     *  "created_at": "Aug 9, 2023"
     * }
     * @authenticated
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
