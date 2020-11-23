<?php

namespace App\Router\Exceptions;

use Exception;

class HandlerNotSupported extends Exception
{
    public function __construct(string $message = 'Handler not supported', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
