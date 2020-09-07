<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\DI;

class ServiceConfig
{
    private string $className;

    private array $params = [];

    public static function autowire(string $className): self
    {
        $self = new self();

        $self->className = $className;

        return $self;
    }

    public function addParam(string $name, $value): self
    {
        $this->params[$name] = $value;

        return $this;
    }

    public function getParam(string $name)
    {
        if (!isset($this->params[$name])) {
            throw new \InvalidArgumentException(sprintf('No such param %s in container', $name));
        }

        return $this->params[$name];
    }
}
