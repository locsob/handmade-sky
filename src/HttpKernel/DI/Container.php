<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\DI;

class Container
{
    /**
     * @var ServiceConfig[]
     */
    private array $services = [];

    public function autowire(string $class): ServiceConfig
    {
        $serviceConfig = ServiceConfig::autowire($class);
        $this->services[$class] = $serviceConfig;

        return $serviceConfig;
    }

    public function get(string $depClass)
    {
        if (isset($this->services[$depClass])) {
            return $this->services[$depClass];
        }

        throw new \InvalidArgumentException(sprintf('No such class %s', $depClass));
    }
}
