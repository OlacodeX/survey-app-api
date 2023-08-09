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
     * @group Admin
     * 
     * Add question to a survey.
     *
     * This endpoint allows an admin to edit a survey question
     * @bodyParam question string sometimes The question of the survey. Example: My Question
     * @bodyParam type string sometimes The question type which can either be 0 - text, 1 - single_choice, 2 - multiple_choice and 3 - number. Example: 0
     * @response 200 {
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
