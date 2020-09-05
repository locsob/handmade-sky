<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\Db\SqliteClient;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;
use Skytest\Security\TokenStorage;

class HomeController extends AbstractController
{
    private SqliteClient $client;
    /**
     * @var TokenStorage
     */
    private TokenStorage $tokenStorage;

    /**
     * HomeController constructor.
     * @param SqliteClient $client
     * @param TokenStorage $tokenStorage
     */
    public function __construct(SqliteClient $client, TokenStorage $tokenStorage)
    {
        $this->client = $client;
        $this->tokenStorage = $tokenStorage;
    }

    public function index(Request $request): Response
    {
        $user = $this->tokenStorage->getCurrentUser();

        return $this->template('home.php', ['email' => $user->getEmail()]);
    }
}
