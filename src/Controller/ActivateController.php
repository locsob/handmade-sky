<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\HttpKernel\Response\RedirectResponse;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;
use Skytest\Service\EmailActivationService;

class ActivateController extends AbstractController
{
    private UserGateway $userGateway;

    private EmailActivationService $activationService;

    private TokenStorage $tokenStorage;

    /**
     * ActivateController constructor.
     * @param UserGateway $userGateway
     * @param EmailActivationService $activationService
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        UserGateway $userGateway,
        EmailActivationService $activationService,
        TokenStorage $tokenStorage
    ) {
        $this->userGateway = $userGateway;
        $this->activationService = $activationService;
        $this->tokenStorage = $tokenStorage;
    }

    public function index(Request $request)
    {
        return $this->template('show-activate.php');
    }

    public function send(Request $request)
    {
        $email = $request->getPostParam('email');

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
