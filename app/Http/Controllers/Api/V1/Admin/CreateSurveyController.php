<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateSurveyRequest;
use App\Models\Survey;
use App\Contracts\SurveyContract;
use App\Http\Resources\SurveyResource;
use Illuminate\Http\Response;

class CreateSurveyController extends Controller
{
   /**
     * @group Admin
     * 
     * Add new survey.
     *
     * This endpoint allows an admin to create a new survey
     * @bodyParam title string required The title of the survey. Example: My Survey
     * @bodyParam expires_at string required The survey end date. Example: 2023-10-09
     * @response 201 {
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
     * @authenticated
     */
    public function __invoke(CreateSurveyRequest $request)
    {
        $validatedInput = $request->validated();
        $survey = new Survey;
        $survey->title = $validatedInput[SurveyContract::TITLE];
        $survey->created_by = Auth::user()->id;
        $survey->expires_at = $validatedInput[SurveyContract::EXPIRES_AT];
        $survey->save();

        return new SurveyResource($survey,Response::HTTP_CREATED);
    }
}
