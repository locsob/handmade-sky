<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;

class LoginController extends AbstractController
{
    private UserGateway $userGateway;

    private TokenStorage $tokenStorage;

    /**
     * LoginController constructor.
     * @param UserGateway $userGateway
     * @param TokenStorage $tokenStorage
     */
    public function __construct(UserGateway $userGateway, TokenStorage $tokenStorage)
    {
        $this->userGateway = $userGateway;
        $this->tokenStorage = $tokenStorage;
    }

    public function index(): Response
    {
        return $this->template('login.php');
    }

    public function login(Request $request): Response
    {
        $user = $this->userGateway->findByEmail($request->getPostParam('email'));

        if ($user && $user->isCorrectPassword($request->getPostParam('password'))) {
            $this->tokenStorage->loginUser($user);
        }

        return $this->redirect('/home');
    }
}
