<?php

namespace App\Exceptions;

use Exception;

class WrongAnswerTypeException extends Exception
{
    protected $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}
