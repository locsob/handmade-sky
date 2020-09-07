<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\Security\TokenStorage;

class WelcomeController extends AbstractController
{
    public function __construct(TokenStorage $tokenStorage)
    {
        parent::__construct($tokenStorage);
    }

    public function index()
    {
        return $this->template('hello.php');
    }
}
