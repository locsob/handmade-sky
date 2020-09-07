<?php

use Skytest\Security\CsrfMiddleware;
use Skytest\Security\SecurityGuardMiddleware;
use Skytest\Security\UserActivationMiddleware;

return [
    SecurityGuardMiddleware::class,
    UserActivationMiddleware::class,
    CsrfMiddleware::class
];
