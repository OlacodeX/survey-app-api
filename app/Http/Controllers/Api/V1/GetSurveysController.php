<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Http\Resources\SurveyResource;

class GetSurveysController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->route('id')) {

            try {
                $survey = Survey::with('questions')->findorfail($request->route('id'));
            } catch (ModelNotFoundException $exception) {
                return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
            }
            
            return new SurveyResource($survey, Response::HTTP_OK);
        }
        $surveys = Survey::with('creator')->paginate();
        return !empty($surveys) ?  SurveyResource::collection($surveys, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
