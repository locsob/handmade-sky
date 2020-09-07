<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;

class CredentialsController extends AbstractController
{
    private TokenStorage $tokenStorage;

    private UserGateway $userGateway;

    /**
     * CredentialsController constructor.
     * @param TokenStorage $tokenStorage
     * @param UserGateway $userGateway
     */
    public function __construct(TokenStorage $tokenStorage, UserGateway $userGateway)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userGateway = $userGateway;
    }

    public function index(): Response
    {
        return $this->template('change-credentials.php');
    }

    public function change(Request $request): Response
    {
        $name = $request->getPostParam('name');
        $password = $request->getPostParam('password');

        $user = $this->tokenStorage->getCurrentUser();

        $user->changeCredentials($name, $password);

        $this->userGateway->update($user);

        $this->tokenStorage->logout();

        return $this->redirect('/login');
    }
}
