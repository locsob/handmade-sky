<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\Response;

class HomeController extends AbstractController
{
    private Gener $ger;

    /**
     * HomeController constructor.
     * @param Gener $ger
     */
    public function __construct(Gener $ger)
    {
        $this->ger = $ger;
    }

    public function index(Request $request): Response
    {
        return $this->template('home.php', ['name' => $request->get('name')]);
    }
}
