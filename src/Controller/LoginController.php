<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;
use Skytest\Service\ValidateService;

class LoginController extends AbstractController
{
    private UserGateway $userGateway;

    /**
     * @var ValidateService
     */
    private ValidateService $validateService;

    /**
     * LoginController constructor.
     * @param UserGateway $userGateway
     * @param TokenStorage $tokenStorage
     * @param ValidateService $validateService
     */
    public function __construct(
        UserGateway $userGateway,
        TokenStorage $tokenStorage,
        ValidateService $validateService
    ) {
        parent::__construct($tokenStorage);
        $this->userGateway = $userGateway;
        $this->tokenStorage = $tokenStorage;
        $this->validateService = $validateService;
    }

    public function index(Request $request): Response
    {
        return $this->template('login.php', ['error' => $request->getQueryParam('error')]);
    }

    public function login(Request $request): Response
    {
        $name = $request->getPostParam('name');
        $password = $request->getPostParam('password');

        $error = $this->validateService->validate([
            [fn() => empty($name), 'Name must be not empty'],
            [fn() => empty($password), 'Password must be not empty'],
        ]);

        if ($error) {
            return $this->redirect('/login', compact('error'));
        }

        $user = $this->userGateway->findByName($name);

        $error = $this->validateService->validate([
            [fn() => !$user, 'User not exists'],
        ]);

        if ($error) {
            return $this->redirect('/login', compact('error'));
        }

        $isCorrectPassword = $user->isCorrectPassword($password);

        $error = $this->validateService->validate([
            [fn() => !$isCorrectPassword, 'Password incorrect'],
        ]);

        if ($error) {
            return $this->redirect('/login', compact('error'));
        }

        if ($user && $isCorrectPassword) {
            $this->tokenStorage->loginUser($user);
        }

        return $this->redirect('/home');
    }
}
