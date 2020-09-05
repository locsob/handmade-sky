<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

use Skytest\Controller\HomeController;

class RouteResolver
{
    public function getController(Request $request): array
    {
        return [[new HomeController(), 'hello'], []];
    }
}
