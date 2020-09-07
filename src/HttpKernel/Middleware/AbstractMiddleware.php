<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\Middleware;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    protected ?MiddlewareInterface $next = null;

    public function setNext(MiddlewareInterface $middleware): void
    {
        $this->next = $middleware;
    }

    protected function handleNext(Request $request, ?Response $response)
    {
        if ($this->next) {
            return $this->next->handle($request, $response);
        }

        return [$request, $response];
    }
}
