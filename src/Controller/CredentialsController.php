<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;
use Skytest\Service\ValidateService;

class CredentialsController extends AbstractController
{
    private UserGateway $userGateway;
    /**
     * @var ValidateService
     */
    private ValidateService $validateService;

    /**
     * CredentialsController constructor.
     * @param TokenStorage $tokenStorage
     * @param UserGateway $userGateway
     * @param ValidateService $validateService
     */
    public function __construct(
        TokenStorage $tokenStorage,
        UserGateway $userGateway,
        ValidateService $validateService
    ) {
        parent::__construct($tokenStorage);
        $this->userGateway = $userGateway;
        $this->validateService = $validateService;
    }

    public function index(Request $request): Response
    {
        return $this->template('change-credentials.php', ['error' => $request->getQueryParam('error')]);
    }

    public function change(Request $request): Response
    {
        $name = $request->getPostParam('name');
        $password = $request->getPostParam('password');

        $user = $this->tokenStorage->getCurrentUser();

        $error = $this->validateService->validate([
            [fn() => empty($name), 'Name must be not empty'],
            [fn() => empty($password), 'Password must be not empty'],
            [fn() => $user->getName() !== $name && $this->userGateway->findByName($name), sprintf('User with name %s already exists', $name)]
        ]);

        if ($error) {
            return $this->redirect('/change_credentials', compact('error'));
        }

        $user->changeCredentials($name, $password);

        $this->userGateway->update($user);

        $this->tokenStorage->logout();

        return $this->redirect('/login');
    }
}
