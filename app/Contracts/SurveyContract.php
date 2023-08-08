<?php
namespace App\Contracts;

class SurveyContract implements ContractInterface{

    public const ID = 'id';
    public const CREATOR = 'creator';
    public const CREATED_BY = 'created_by';
    public const TITLE = 'title';
    public const SLUG = 'slug';
    public const TYPE = 'type';
    public const EXPIRES_AT = 'expires_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}
