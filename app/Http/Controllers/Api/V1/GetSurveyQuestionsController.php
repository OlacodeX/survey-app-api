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
     * Handle the incoming request.
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
