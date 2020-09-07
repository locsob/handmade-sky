<?php

use Skytest\Db\SqliteClient;
use Skytest\HttpKernel\DI\Container;
use Skytest\Model\UserGateway;
use Skytest\Security\SecurityGuardMiddleware;
use Skytest\Security\TokenStorage;
use Skytest\Service\EmailActivationService;

/** @var Container $container */

$container->autowire(UserGateway::class);

$container->autowire(SqliteClient::class);

$container->autowire(TokenStorage::class);

$container->autowire(SecurityGuardMiddleware::class)
    ->addParam('guardConfigFile', ROOT_PATH . 'config/security.php');

$container->autowire(EmailActivationService::class);
