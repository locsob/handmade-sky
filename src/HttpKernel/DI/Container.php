<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\DI;

class Container
{
    private array $services = [];

    public function autowire(string $class): void
    {
        $this->services[$class] = $class;
    }

    public function get(string $depClass)
    {
        if (isset($this->services[$depClass])) {
            return $this->services[$depClass];
        }

        throw new \InvalidArgumentException(sprintf('No such class %s', $depClass));
    }
}
