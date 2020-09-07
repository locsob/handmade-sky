<?php

use Skytest\Controller\ActivateController;
use Skytest\Controller\CredentialsController;
use Skytest\Controller\HomeController;
use Skytest\Controller\LoginController;
use Skytest\Controller\LogoutController;
use Skytest\Controller\SignupController;
use Skytest\Controller\WelcomeController;

return [
     ['/home', 'GET', HomeController::class, 'index'],
     ['/login', 'GET', LoginController::class, 'index'],
     ['/login', 'POST', LoginController::class, 'login'],
     ['/signup', 'GET', SignupController::class, 'index'],
     ['/signup', 'POST', SignupController::class, 'signup'],
     ['/logout', 'POST', LogoutController::class, 'logout'],
     ['/', 'GET', WelcomeController::class, 'index'],
     ['/activate', 'GET', ActivateController::class, 'activate'],
     ['/show-activate', 'GET', ActivateController::class, 'index'],
     ['/send-activate', 'POST', ActivateController::class, 'send'],
     ['/change_credentials', 'GET', CredentialsController::class, 'index'],
     ['/change_credentials', 'POST', CredentialsController::class, 'change'],
];
