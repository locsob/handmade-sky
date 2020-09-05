<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\Db\SqliteClient;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class HomeController extends AbstractController
{
    private SqliteClient $client;

    /**
     * HomeController constructor.
     * @param SqliteClient $client
     */
    public function __construct(SqliteClient $client)
    {
        $this->client = $client;
    }

    public function index(Request $request): Response
    {
        return $this->template('home.php');
    }
}
