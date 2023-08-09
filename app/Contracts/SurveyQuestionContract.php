<?php
namespace App\Contracts;

class SurveyQuestionContract implements ContractInterface{

    public const ID = 'id';
    public const QUESTION = 'question';
    public const SURVEY = 'survey';
    public const SURVEY_ID = 'survey_id';
    public const TYPE = 'type';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}
