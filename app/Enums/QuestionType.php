<?php

namespace App\Enums;

enum QuestionType: int implements Base
{
    case TEXT = 0;
    case SINGLE_CHOICE = 1;
    case MULTIPLE_CHOICE = 2;
    case NUMBER = 3;

    public function title(): string
    {
        return match($this){
            self::TEXT => 'Text',
            self::SINGLE_CHOICE => 'Single Choice',
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::NUMBER => 'Number',
        };
    }

    public function badge(): string
    {
        return match($this){
            self::TEXT => '',
            self::SINGLE_CHOICE => '',
            self::MULTIPLE_CHOICE => '',
            self::NUMBER => '',
        };
    }

    public function icon(): string
    {
        return match($this){
            self::TEXT => '',
            self::SINGLE_CHOICE => '',
            self::MULTIPLE_CHOICE => '',
            self::NUMBER => '',
        };
    }
}
