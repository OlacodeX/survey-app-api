<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteSurveyQuestionController extends Controller
{
     /**
     * @group Admin
     * 
     * Delete question from a survey.
     *
     * This endpoint allows an admin to delete question from a survey
     * @response 200 {},
     * @authenticated
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

        $question->delete();
        return response()->json([], Response::HTTP_OK);
    }
}
