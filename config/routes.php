<?php

use Skytest\Controller\HomeController;
use Skytest\Controller\LoginController;
use Skytest\Controller\LogoutController;
use Skytest\Controller\SignupController;

return [
     ['/home', 'GET', HomeController::class, 'index'],
     ['/login', 'GET', LoginController::class, 'index'],
     ['/login', 'POST', LoginController::class, 'login'],
     ['/signup', 'GET', SignupController::class, 'index'],
     ['/signup', 'POST', SignupController::class, 'signup'],
     ['/logout', 'POST', LogoutController::class, 'logout']
];
