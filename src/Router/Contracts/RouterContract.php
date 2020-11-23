<?php

namespace App\Router\Contracts;

use App\Router\Route;

interface RouterContract
{
    /**
     * @param Clousure|array $handler
     */
    public function get(string $uri, $handler) : Route;

    /**
     * @param Clousure|array $handler
     */
    public function post(string $uri, $handler) : Route;

    /**
     * @param Clousure|array $handler
     */
    public function put(string $uri, $handler) : Route;

    /**
     * @param Clousure|array $handler
     */
    public function delete(string $uri, $handler) : Route;

    /**
     * @param Clousure|array $handler
     */
    public function patch(string $uri, $handler) : Route;

    /**
     * @param Clousure|array $handler
     */
    public function options(string $uri, $handler) : Route;

    public function dispatch();
}
