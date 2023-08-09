<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswersResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetSurveyQuestionAnswersController extends Controller
{
     /**
     * @group Admin
     * 
     * Get survey question answers.
     *
     * This endpoint allows an admin to view answers for survey questions 
     * @response 200 {{
            *"id": "99d9b176-0ff8-475f-97f7-0f04a788cb5c",
            *"answer": "addsdff fdffrrff effd",
            *"sur*vey": {
                *"id": "99d88e74-00ce-4ad8-80c9-b53d4cc0bf01",
                *"title": "Test Survey Edited",
               * "question": {
                    *"id": "99d890e6-fcde-493e-858f-28d96724c942",
                    *"question": "Where are you from",
                   * "type": "Multiple Choice"
                *}
            *},
            *"created_at": "2023-08-09T17:37:22.000000Z"
        *},
        *{
            *"id": "99d9b176-162a-4f26-8c97-cea63880a7f4",
            *"answer": "do this, do not do this",
            *"survey": {
                *"id": "99d88e74-00ce-4ad8-80c9-b53d4cc0bf01",
                *"title": "Test Survey Edited",
                *"question": {
                    *"id": "99d890e9-ed26-433c-ad4c-5ead5ee3435b",
                    *"question": "What is your name",
                    *"type": "Text"
                *}
           * },
            *"created_at": "2023-08-09T17:37:22.000000Z"
       * }
     * }
     * @authenticated
     * 
     */
    public function __invoke(Request $request)
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

        $answers = $question->answers()->paginate();
        return count($answers) > 0 ? AnswersResource::collection($answers, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
