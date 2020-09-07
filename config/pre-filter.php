<?php

use Skytest\Security\SecurityGuardMiddleware;
use Skytest\Security\UserActivationMiddleware;

return [
    SecurityGuardMiddleware::class,
    UserActivationMiddleware::class,
];
