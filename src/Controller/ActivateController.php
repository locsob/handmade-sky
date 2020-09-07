<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\HttpKernel\Response\RedirectResponse;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;
use Skytest\Service\EmailActivationService;
use Skytest\Service\ValidateService;

class ActivateController extends AbstractController
{
    private UserGateway $userGateway;

    private EmailActivationService $activationService;

    /**
     * @var ValidateService
     */
    private ValidateService $validateService;

    /**
     * ActivateController constructor.
     * @param UserGateway $userGateway
     * @param EmailActivationService $activationService
     * @param TokenStorage $tokenStorage
     * @param ValidateService $validateService
     */
    public function __construct(
        UserGateway $userGateway,
        EmailActivationService $activationService,
        TokenStorage $tokenStorage,
        ValidateService $validateService
    ) {
        parent::__construct($tokenStorage);

        $this->userGateway = $userGateway;
        $this->activationService = $activationService;
        $this->validateService = $validateService;
    }

    public function index(Request $request)
    {
        return $this->template('show-activate.php', ['error' => $request->getQueryParam('error')]);
    }

    public function send(Request $request)
    {
        $email = $request->getPostParam('email');

        $error = $this->validateService->validate([
            [fn() => !filter_var($email, FILTER_VALIDATE_EMAIL), 'Email not valid'],
        ]);

        if ($error) {
            return $this->redirect('/show-activate', compact('error'));
        }

        if ($email) {
            $this->activationService->send($email, $request->getDomain());

            $this->tokenStorage->logout();
        }

        return $this->redirect('/login');
    }

    public function activate(Request $request): Response
    {
        $code = $request->getQueryParam('code');

        if ($code) {
            $user = $this->userGateway->findByActivationCode($code);

            $user->activate($code);

            $this->userGateway->update($user);
        }

        return new RedirectResponse('/login');
    }
}
