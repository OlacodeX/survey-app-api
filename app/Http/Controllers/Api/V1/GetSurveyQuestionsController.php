<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Http\Resources\SurveyQuestionResource;

class GetSurveyQuestionsController extends Controller
{
    /**
     * @group Users
     * 
     * Get survey questions.
     *
     * This endpoint allows a user to get survey questions
     * @response 200 {{
     *  "id": d346fd9f-a86a-47e5-ba30-b3d25e69bfd4,
     *  "question": "Question One",
     *  "type": "Text",
     *  "survey": {
     *      "id":"99d88e74-00ce-4ad8-80c9-b53d4cc0bf01",
     *       "title": "Title one"
     * },
     *  "created_at": "Aug 9, 2023"
     * },
     * {
     *  "id": d346fd9f-a86a-47e5-ba30-b3d25e69bfd4,
     *  "question": "Question Two",
     *  "type": "Text",
     *  "survey": {
     *      "id":"99d88e74-00ce-4ad8-80c9-b53d4cc0bf01",
     *       "title": "Title Two"
     * },
     *  "created_at": "Aug 9, 2023"
     * }}
     * 
     */
    public function __invoke(Request $request)
    {
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }

        if ($request->route('question_id')) {
            try {
                $question = $survey->questions()->findorfail($request->route('question_id'));
            } catch (ModelNotFoundException $exception) {
                return response()->json("No question found with the provided ID on this survey", Response::HTTP_NOT_FOUND);
            }
            return new SurveyQuestionResource($question, Response::HTTP_OK);
        }

        $questions = $survey->questions()->paginate();
        return count($questions) > 0 ? SurveyQuestionResource::collection($questions, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
