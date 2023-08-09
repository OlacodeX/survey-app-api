<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteSurveyController extends Controller
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
        $survey->delete();
        return response()->json([], Response::HTTP_OK);
    }
}
