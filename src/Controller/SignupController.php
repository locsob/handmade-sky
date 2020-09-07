<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\User;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;
use Skytest\Service\ValidateService;

class SignupController extends AbstractController
{
    private UserGateway $userGateway;
    /**
     * @var ValidateService
     */
    private ValidateService $validateService;


    /**
     * SignupController constructor.
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
        $this->validateService = $validateService;
    }

    public function index(Request $request): Response
    {
        return $this->template('signup.php', ['error' => $request->getQueryParam('error')]);
    }

    public function signup(Request $request): Response
    {
        $name = $request->getPostParam('name');
        $password = $request->getPostParam('password');

        $error = $this->validateService->validate([
            [fn() => empty($name), 'Name must be not empty'],
            [fn() => empty($password), 'Password must be not empty'],
            [fn() => $this->userGateway->findByName($name), sprintf('User with name %s already exists', $name)],
        ]);

        if ($error) {
            return $this->redirect('/signup', compact('error'));
        }

        $user = User::create($name, $password);
        $this->userGateway->insert($user);

        $this->tokenStorage->loginUser($user);

        return $this->redirect('/home');
    }
}
