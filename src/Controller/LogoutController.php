<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Security\TokenStorage;

class LogoutController extends AbstractController
{
    private TokenStorage $tokenStorage;

    /**
     * LogoutController constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function logout(): Response
    {
        $this->tokenStorage->logout();

        return $this->redirect('/login');
    }
}
