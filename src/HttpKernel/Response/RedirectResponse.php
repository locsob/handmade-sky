<?php

declare(strict_types=1);

namespace Skytest\HttpKernel\Response;

use Skytest\HttpKernel\Response;

class RedirectResponse extends Response
{
    public function __construct(string $route)
    {
        parent::__construct('', 301, ['Location' => $route]);
    }
}
