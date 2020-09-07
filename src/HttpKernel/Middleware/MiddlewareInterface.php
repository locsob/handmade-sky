<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\Middleware;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, ?Response $response): array;
    public function setNext(MiddlewareInterface $middleware): void;
}
