<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Response;
use Skytest\Security\TokenStorage;

class NotFoundController extends AbstractController
{
    public function __construct(TokenStorage $tokenStorage)
    {
        parent::__construct($tokenStorage);
    }

    public function index(): Response
    {
        return $this->template('not-found.php');
    }
}
