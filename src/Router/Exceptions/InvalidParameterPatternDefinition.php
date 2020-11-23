<?php

namespace App\Router\Exceptions;

use Exception;

class InvalidParameterPatternDefinition extends Exception
{
    public function __construct(string $message = 'Parameter or pattern is incorret', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
