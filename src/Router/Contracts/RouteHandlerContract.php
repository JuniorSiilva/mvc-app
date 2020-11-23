<?php

namespace App\Router\Contracts;

use App\Router\Route;

interface RouteHandlerContract
{
    public function execute(Route $route) : bool;
}
