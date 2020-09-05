<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Response;

class LoginController extends AbstractController
{
    public function index(): Response
    {
        return $this->template('login.php');
    }
}
