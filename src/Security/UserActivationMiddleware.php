<?php

declare(strict_types=1);

namespace Skytest\Security;

use Skytest\HttpKernel\Middleware\AbstractMiddleware;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class UserActivationMiddleware extends AbstractMiddleware
{
    private TokenStorage $tokenStorage;

    /**
     * UserActivationMiddleware constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function handle(Request $request, ?Response $response): array
    {
        $user = $this->tokenStorage->findCurrentUser();

        if ($user && !$user->isActivated() && !in_array($request->getPath(), ['/show-activate', '/send-activate'])) {
            $response = new Response\RedirectResponse('/show-activate');
        }

        return $this->handleNext($request, $response);
    }
}
