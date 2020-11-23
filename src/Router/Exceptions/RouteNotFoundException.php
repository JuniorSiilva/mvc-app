<?php

namespace App\Router\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
    public function __construct(string $message = 'Route not found', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
