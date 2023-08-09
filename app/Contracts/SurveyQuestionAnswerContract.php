<?php
namespace App\Contracts;

use App\Contracts\SurveyQuestionContract;

class SurveyQuestionAnswerContract extends SurveyQuestionContract{

    public const ID = 'id';
    public const QUESTION_ID = 'question_id';
    public const ANSWER = 'answer';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}
