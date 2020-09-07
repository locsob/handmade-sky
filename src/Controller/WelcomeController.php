<?php

declare(strict_types=1);

namespace Skytest\Controller;

class WelcomeController extends AbstractController
{
    public function index()
    {
        return $this->template('hello.php');
    }
}
