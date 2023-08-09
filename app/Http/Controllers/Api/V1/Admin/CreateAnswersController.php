<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAnswersRequest;
use App\Http\Resources\AnswersResource;
use App\Models\SurveyQuestionAnswer;
use App\Http\Resources\SurveyQuestionResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateAnswersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateAnswersRequest $request)
    { 
        try {
            $survey = Survey::findorfail($request->route('id'));
        } catch (ModelNotFoundException $exception) {
            return response()->json("No survey found with the provided ID", Response::HTTP_NOT_FOUND);
        }
        
        $validatedInput = $request->validated();
        // return array_values($validatedInput);
        // return $validatedInput = $request->validated()['answer']['99d890e6-fcde-493e-858f-28d96724c942'];
        foreach ($validatedInput['answer'] as $question_id => $answer_array) {
            // dd($answer_array);
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
