<?php

declare(strict_types=1);

namespace Skytest\Security;

use Skytest\HttpKernel\Middleware\AbstractMiddleware;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class CsrfMiddleware extends AbstractMiddleware
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
        $csrf = $this->tokenStorage->getCsrfToken();
        $requestCsrf = $request->getPostParam('csrf');

        $isCorrectCsrf = $csrf === $requestCsrf;

        if ($request->isPost() && !$isCorrectCsrf) {
            $response = new Response\RedirectResponse('/home');
        };

        return $this->handleNext($request, $response);
    }
}
