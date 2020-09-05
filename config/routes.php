<?php

use Skytest\Controller\HomeController;
use Skytest\Controller\LoginController;
use Skytest\Controller\SignupController;

return [
     ['/home', 'GET', HomeController::class, 'index'],
     ['/login', 'GET', LoginController::class, 'index'],
     ['/signup', 'GET', SignupController::class, 'index'],
     ['/signup', 'POST', SignupController::class, 'signup']
];
