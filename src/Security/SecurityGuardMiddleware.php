<?php

declare(strict_types=1);

namespace Skytest\Security;

use Skytest\HttpKernel\Middleware\AbstractMiddleware;
use Skytest\HttpKernel\Middleware\MiddlewareInterface;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class SecurityGuardMiddleware extends AbstractMiddleware implements MiddlewareInterface
{
    private TokenStorage $tokenStorage;

    private string $guardConfigFile;

    /**
     * @var array{guarded_paths:array<string>}
     */
    private array $guardConfig;

    /**
     * SecurityGuardMiddleware constructor.
     * @param TokenStorage $tokenStorage
     * @param string $guardConfigFile
     */
    public function __construct(TokenStorage $tokenStorage, string $guardConfigFile)
    {
        $this->tokenStorage = $tokenStorage;
        $this->guardConfig = require_once $guardConfigFile;
    }

    public function handle(Request $request, ?Response $response): array
    {
        $isGuest = $this->tokenStorage->isGuest();

        $isGuardedPath = $this->isGuardedPath($request->getPath());

        if ($isGuest && $isGuardedPath) {
            $response = new Response\RedirectResponse('/login');
        } elseif (!$isGuest && !$isGuardedPath) {
            $response = new Response\RedirectResponse('/home');
        }

        return $this->handleNext($request, $response);
    }

    private function isGuardedPath(string $path): bool
    {
        return in_array($path, $this->guardConfig['guarded_paths']);
    }
}
