<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswersResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetSurveyQuestionAnswersController extends Controller
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

        try {
            $question = $survey->questions()->findorfail($request->route('question_id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No question found with the provided ID on this survey", Response::HTTP_NOT_FOUND);
        }

        $answers = $question->answers()->paginate();
        return count($answers) > 0 ? AnswersResource::collection($answers, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
