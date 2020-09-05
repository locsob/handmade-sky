<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Response;

class HomeController
{
    public function hello(): Response
    {
        return new Response('hello12');
    }
}
