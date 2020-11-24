<?php

namespace App\Router\Contracts;

interface RouteContract
{
    public function setName(?string $name) : self;

    public function getMethod() : string;

    public function getUri() : string;

    public function getName() : string;

    public function getUriPattern() : string;

    public function run(string $url) : bool;
}
