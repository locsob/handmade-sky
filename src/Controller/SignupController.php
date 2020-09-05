<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Model\User;
use Skytest\Model\UserGateway;

class SignupController extends AbstractController
{
    private UserGateway $userGateway;

    /**
     * SignupController constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function index(): Response
    {
        return $this->template('signup.php');
    }

    public function signup(Request $request): Response
    {
        $email = $request->getPostParam('email');
        $password = $request->getPostParam('password');

        $user = new User($email, $password);
        $this->userGateway->insert($user);

        return $this->redirect('/login');
    }
}
