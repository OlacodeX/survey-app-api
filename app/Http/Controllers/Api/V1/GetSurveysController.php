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
     * @group Users
     * 
     * Get List of Surveys.
     *
     * This endpoint allows a user to get the list of surveys
     * @response 200 {
     * {
     *  "id": d346fd9f-a86a-47e5-ba30-b3d25e69bfd4,
     *  "title": "Title One",
     *  "slug": "title_one",
     *  "creator": {
     *       "name": "olawale",
     *       "email": "aluko798@gmail.com"
     * },
     *  "expires_at": "Oct 17, 2023",
     *  "created_at": "Aug 9, 2023"
     * },
     * {
     *  "id": d346fd9f-a86a-47e5-ba30-b3d25e69bfd4,
     *  "title": "Title One",
     *  "slug": "title_one",
     *  "creator": {
     *       "name": "olawale",
     *       "email": "aluko798@gmail.com"
     * },
     *  "expires_at": "Oct 17, 2023",
     *  "created_at": "Aug 9, 2023"
     * }
     * }
     * 
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
        return $surveys ?  SurveyResource::collection($surveys, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
