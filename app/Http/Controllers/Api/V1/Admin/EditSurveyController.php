<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditSurveyRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use App\Models\Survey;
use App\Contracts\SurveyContract;
use App\Http\Resources\SurveyResource;

class EditSurveyController extends Controller
{
   /**
     * @group Admin
     * 
     * Edit Existing survey.
     *
     * This endpoint allows an admin to edit an existing survey
     * @bodyParam title string sometimes The title of the survey. Example: My Survey
     * @bodyParam expires_at string sometimes The survey end date. Example: 2023-10-09
     * @response 200 {
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
    public function __invoke(EditSurveyRequest $request)
    {
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }

        $validatedInput = $request->validated();
        $request->input('title') ? $survey->title = $validatedInput[SurveyContract::TITLE] : null;
        $request->input('expires_at') ? $survey->expires_at = $validatedInput[SurveyContract::EXPIRES_AT] : null;
        $survey->save();

        return new SurveyResource($survey,Response::HTTP_OK);
    }
}
