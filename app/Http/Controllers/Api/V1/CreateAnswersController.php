<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Survey;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\SurveyQuestionAnswer;
use App\Http\Resources\AnswersResource;
use App\Http\Requests\CreateAnswersRequest;
use App\Exceptions\WrongAnswerTypeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateAnswersController extends Controller
{
    /**
     * @group Users
     * 
     * Answer survey questions.
     *
     * This endpoint allows a user to provide answers to survey questions 
     * @bodyParam answer object required An array of the key value pair items where the question id is the key and answer to the question the value. Example: {
        *"answer": {
        *"99d890e6-fcde-493e-858f-28d96724c942": {
            *"answer": "addsdff fdffrrff effd"
        *},
        *"99d890e9-ed26-433c-ad4c-5ead5ee3435b": {
            *"answer": "do this, do not do this"
       * }
        *}}
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
     */
    public function __invoke(CreateAnswersRequest $request)
    { 
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }
        
        $validatedInput = $request->validated();
        
        // Validate answers are of same types with question types
        try {
            $survey->validateAnswers($validatedInput['answer']);
        } catch (WrongAnswerTypeException $e) {
            return response()->json($e->getErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        foreach ($validatedInput['answer'] as $question_id => $answer_array) {
            
            try {
                $question = $survey->questions()->findorfail($question_id);
            } catch (ModelNotFoundException $exception) {
                
            }
            $answer = new SurveyQuestionAnswer;
            $answer->answer = $validatedInput['answer'][$question_id]['answer'];
            $answer->question_id = $question->id;
            $answer->survey_id = $question->survey->id;
            $answer->save();
        }
        $answers = SurveyQuestionAnswer::where('survey_id', $request->route('id'))->paginate();
        return count($answers) > 0 ? AnswersResource::collection($answers, Response::HTTP_OK) : response()->json([],Response::HTTP_OK);
    }
}
