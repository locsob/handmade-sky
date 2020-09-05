<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

use Skytest\Controller\HomeController;

class MiddlewareChain
{
    private array $middlewares;

    public function handle(Request $request, Response $response): Response
    {
        return $response;
    }
}
