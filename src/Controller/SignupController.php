<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\User;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;

class SignupController extends AbstractController
{
    private UserGateway $userGateway;
    /**
     * @var TokenStorage
     */
    private TokenStorage $tokenStorage;


    /**
     * SignupController constructor.
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
        return $this->template('signup.php');
    }

    public function signup(Request $request): Response
    {
        $name = $request->getPostParam('name');
        $password = $request->getPostParam('password');

        $user = User::create($name, $password);
        $this->userGateway->insert($user);

        $this->tokenStorage->loginUser($user);

        return $this->redirect('/home');
    }
}
