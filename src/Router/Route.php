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

    private array $parameters = [];

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

                    return '(' . $this->getParameterPattern($parameter) . ')';
                },
                '~/?{{([^}]*)?}}~' => function ($matches) {
                    $parameter = explode('?', $matches[1])[0];

                    return '(?:/(' . $this->getParameterPattern($parameter) . '))?';
                },
            ],
            $this->uri
        );

        return '~^(?:/?)' . $uriPattern . '(?:/?)*$~';
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

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter(string $key, $default)
    {
        return $this->parameters[$key] ?? $default;
    }

    private function loadParametersValues(string $url)
    {
        preg_match($this->getUriPattern(), $url, $values);

        array_splice($values, 0, 1);

        return $values;
    }

    private function loadParametersKeys()
    {
        $newUri = str_replace('?', '', $this->getUri());

        preg_match_all('~{{([^}?]*)}}~', $newUri, $keys, PREG_SET_ORDER);

        $keys = array_map(function ($m) {
            return $m[1];
        }, $keys);

        return $keys;
    }

    private function loadParameters(string $url)
    {
        $keys = $this->loadParametersKeys();

        $values = $this->loadParametersValues($url);

        foreach ($keys as $index => $k) {
            $this->parameters[$k] = $values[$index] ?? null;
        }
    }

    public function run(string $url) : bool
    {
        $this->loadParameters($url);

        return $this->handler->execute(
            $this
        );
    }
}
