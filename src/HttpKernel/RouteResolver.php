<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

use Skytest\Controller\HomeController;
use Skytest\Controller\NotFoundController;
use Skytest\HttpKernel\DI\Injector;

class RouteResolver
{
    private Injector $injector;

    /**
     * RouteResolver constructor.
     * @param Injector $injector
     */
    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function getController(Request $request): array
    {
        $routes = require_once ROOT_PATH . 'config/routes.php';

        $foundClass = null;
        $foundMethod = null;
        foreach ($routes as [$path, $requestMethod, $class, $method]) {
            if ($path === $request->getPath() && $requestMethod === $request->getMethod()) {
                $foundClass = $class;
                $foundMethod = $method;
            }
        }

        if (!$foundClass) {
            $foundClass = NotFoundController::class;
            $foundMethod = 'index';
        }

        $foundController = $this->injector->resolve($foundClass);

        return [[$foundController, $foundMethod], [$request]];
    }
}
