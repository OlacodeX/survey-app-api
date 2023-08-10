<?php

namespace App\Models\Traits;

use App\Exceptions\WrongAnswerTypeException;

trait ValidateAnswers
{

    public function survey()
    {
        return $this;
    }

    /**
     * Check if question type and answer type are of same type
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function validateAnswers($answers_array)
    {
        $survey = $this->survey();
        $errors = [];
        foreach ($answers_array as $question_id => $answer_array) {
            
            try {
                $question = $survey->questions()->findorFail($question_id);
            } catch (ModelNotFoundException $exception) {
                
            }
            $answer_type = gettype($answers_array[$question_id]['answer']);
            if (strtolower($answer_type) != strtolower($question->type->question_type())) {
                $errors[$question->id] = 'Answer to this question should be '.strtolower($question->type->title());
            }
        }
        if (count($errors) > 0) {
            throw new WrongAnswerTypeException($errors);
        }
    }
}
