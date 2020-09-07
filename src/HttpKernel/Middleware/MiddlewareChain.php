<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\Middleware;

use Skytest\Controller\HomeController;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class MiddlewareChain
{
    /**
     * @var MiddlewareInterface
     */
    private MiddlewareInterface $middlewareChain;

    /**
     * MiddlewareChain constructor.
     * @param MiddlewareInterface[] $middlewares
     */
    public function __construct(array $middlewares)
    {
        $first = null;

        for ($i = 0; $i < count($middlewares); $i++) {
            $current = $middlewares[$i];
            if (!$first) {
                $first = $current;
            }

            $next = null;


            if (isset($middlewares[$i + 1])) {
                $current->setNext($middlewares[$i + 1]);
            }
        }

        $this->middlewareChain = $first;
    }


    /**
     * @param Request $request
     * @return array
     * @psalm-return  array{Request, Response|null}
     */
    public function handleRequest(Request $request): array
    {
        return $this->middlewareChain->handle($request, null);
    }

//    /**
//     * @param Request $request
//     * @param Response $response
//     * @return array
//     * @psalm-return  array{Request, Response}
//     */
//    public function handleResponse(Request $request, Response $response): array
//    {
//        return $this->middlewareChain->handle($request, null);
//    }
}
