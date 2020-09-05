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

        $foundController = null;
        foreach ($routes as $path => $controllerData) {
            if ($path === $request->getPath()) {
                $foundController = $controllerData;
            }
        }

        if (!$foundController) {
            $foundController = [NotFoundController::class, 'index'];
        }

        [$class, $method] = $foundController;

        $foundController = $this->injector->resolve($class);

        return [[$foundController, $method], [$request]];
    }
}
