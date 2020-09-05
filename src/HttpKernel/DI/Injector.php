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
//        require_once __DIR__. '../../../config/services.php';

        $this->container = $container;
    }

    public function resolve(string $className) {
        $reflectionClass = new \ReflectionClass($className);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor) {
            $params = $constructor->getParameters();

            $result = [];
            foreach ($params as $param) {
                $class = $param->getClass();

                $depClass = $class->getName();
                if (class_exists($depClass)) {
                    if ($service = $this->container->get($depClass)) {
                        $result[] = $this->resolve($depClass);
                    }

                }
            }

            return new $className(...$result);
        }

        return new $className();
    }
}
