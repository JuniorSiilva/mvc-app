<?php

namespace App\Router\Traits;

use App\Router\Exceptions\InvalidParameterPatternDefinition;

trait ParameterPattern
{
    private array $parametersPattern = [];

    public function setParametersPattern(array $parameters) : self
    {
        foreach ($parameters as $parameter => $pattern) {
            if (! is_string($parameter) || ! is_string($pattern)) {
                throw new InvalidParameterPatternDefinition;
            }

            $this->setParameterPattern($parameter, $pattern);
        }

        return $this;
    }

    public function setParameterPattern(string $parameter, string $pattern) : self
    {
        $this->parametersPattern[$parameter] = $pattern;

        return $this;
    }

    public function getParameterPattern(string $parameter) :? string
    {
        return $this->parametersPattern[$parameter];
    }

    public function getParametersPattern() : array
    {
        return $this->parametersPattern;
    }
}
