<?php

namespace App\Router;

use Closure;
use App\Router\Contracts\RouteHandlerContract;

class RouteHandler implements RouteHandlerContract
{
    /**
     * @var Closure|array
     */
    protected $handler;

    public function __construct($handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return Clousure|array
     */
    private function getHandler()
    {
        if ($this->handler instanceof Closure) {
            return $this->handler;
        }

        [$class, $method] = $this->handler;

        return [new $class, $method];
    }

    public function execute(Route $route) : bool
    {
        call_user_func_array($this->getHandler(), $route->getParameters());

        return true;
    }
}
