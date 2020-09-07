<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\DI;

class Injector
{
    private Container $container;

    /**
     * Injector constructor.
     */
    public function __construct()
    {
        $this->init();
    }


    public function init()
    {
        $container = new Container();

        require_once ROOT_PATH . 'config/services.php';

        $this->container = $container;
    }

    public function resolve(string $class) {
        $reflectionClass = new \ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor) {
            $params = $constructor->getParameters();

            $result = [];
            foreach ($params as $param) {
                if ($param->getClass()) {
                    $paramClass = $param->getClass();
                    $paramClassName = $paramClass->getName();
                    if (!class_exists($paramClassName)) {
                        throw new \InvalidArgumentException(sprintf('Class %s not exists', $paramClassName));
                    }

                    if (!$service = $this->container->get($paramClassName)) {
                        throw new \InvalidArgumentException(sprintf('Service %s not configured', $paramClassName));
                    }

                    $result[] = $this->resolve($paramClassName);
                } else {
                    $serviceConfig = $this->container->get($class);

                    $result[] = $serviceConfig->getParam($param->getName());
                }
            }

            return new $class(...$result);
        }

        return new $class();
    }

    /**
     * @param array $classes
     * @psalm-param array<class-string> $classes
     * @return array
     */
    public function resolveArray(array $classes): array
    {
        return array_reduce($classes, function ($agg, string $class) {
            return [
                ...$agg,
                $this->resolve($class)
            ];
        }, []);
    }
}
