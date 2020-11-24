<?php

namespace App\Router;

use App\Router\Traits\ParameterPattern;
use App\Router\Contracts\RouterContract;
use App\Router\Exceptions\MethodNotSupported;
use App\Router\Exceptions\RouteNotFoundException;

class Router implements RouterContract
{
    use ParameterPattern {
        ParameterPattern::setParametersPattern as setGlobalParametersPattern;
        ParameterPattern::setParameterPattern as setGlobalParameterPattern;
    }

    private array $routes = [];

    private const METHODS = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS',
    ];

    public function __construct()
    {
        $this->initRoutes();
    }

    public function get(string $uri, $handler) : Route
    {
        return $this->addRoute('GET', $uri, $handler);
    }

    public function post(string $uri, $handler) : Route
    {
        return $this->addRoute('POST', $uri, $handler);
    }

    public function put(string $uri, $handler) : Route
    {
        return $this->addRoute('PUT', $uri, $handler);
    }

    public function delete(string $uri, $handler) : Route
    {
        return $this->addRoute('DELETE', $uri, $handler);
    }

    public function patch(string $uri, $handler) : Route
    {
        return $this->addRoute('PATCH', $uri, $handler);
    }

    public function options(string $uri, $handler) : Route
    {
        return $this->addRoute('OPTIONS', $uri, $handler);
    }

    private function initRoutes() : void
    {
        foreach (self::METHODS as $method) {
            $this->routes[$method] = [];
        }
    }

    private function addRoute(string $method, string $uri, $handler) : Route
    {
        if ($uri === '/') {
            return $this->addRoute($method, '', $handler);
        }

        if (! in_array($method, self::METHODS)) {
            throw new MethodNotSupported;
        }

        array_push(
            $this->routes[$method],
            $route = new Route($method, $uri, $handler)
        );

        $route->setParametersPattern($this->getParametersPattern());

        return $route;
    }

    /**
     * @return Route|false
     */
    private function getRoute(string $method, string $uri)
    {
        $routes = array_filter(
            $this->routes[$method],
            function (Route $route) use ($uri) {
                return preg_match($route->getUriPattern(), $uri);
            }
        );

        $route = end($routes);

        return $route;
    }

    private function getUrl() : string
    {
        return parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );
    }

    private function getMethod() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function dispatch()
    {
        $route = $this->getRoute(
            $this->getMethod(),
            $this->getUrl()
        );

        if (! $route) {
            throw new RouteNotFoundException;
        }

        return $route->run($this->getUrl());
    }
}
