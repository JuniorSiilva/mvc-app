<?php

namespace App\Router\Exceptions;

use Exception;

class MethodNotSupported extends Exception
{
    public function __construct(string $message = 'Method not allowed', int $code = 405)
    {
        parent::__construct($message, $code);
    }
}
