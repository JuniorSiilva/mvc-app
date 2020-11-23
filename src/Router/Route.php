<?php

namespace App\Router;

use App\Router\Contracts\RouteContract;
use App\Router\Traits\ParameterPattern;
use App\Router\Contracts\RouteHandlerContract;

class Route implements RouteContract
{
    use ParameterPattern;

    private string $method;

    private string $originalUri;

    private string $uri;

    private string $name;

    private RouteHandlerContract $handler;

    public function __construct(string $method, string $uri, $handler)
    {
        $this->method = $method;

        $this->originalUri = $uri;

        $this->uri = preg_replace(['/{/', '/}/'], ['{{', '}}'], $uri);

        $this->handler = new RouteHandler($handler);
    }

    public function getUriPattern() : string
    {
        $uriPattern = preg_replace_callback_array([
                '~{{([^}?]*)}}~' => function ($matches) {
                    $parameter = $matches[1];

                    return $this->getParameterPattern($parameter)
                            ? '(' . $this->getParameterPattern($parameter) . ')'
                                : '([^/]+)';
                },
                '~/?{{([^}]*)?}}~' => function ($matches) {
                    $parameter = explode('?', $matches[1])[0];

                    return $this->getParameterPattern($parameter)
                            ? '(/(' . $this->getParameterPattern($parameter) . '))?'
                                : '(/([^/]+))?';
                },
            ],
            $this->uri
        );

        return $uriPattern;
    }

    public function setName(?string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function run() : bool
    {
        return $this->handler->execute($this);
    }
}
