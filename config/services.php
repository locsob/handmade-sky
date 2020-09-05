<?php

use Skytest\Db\SqliteClient;
use Skytest\HttpKernel\DI\Container;
use Skytest\Model\UserGateway;
use Skytest\Security\TokenStorage;

/** @var Container $container */

$container->autowire(UserGateway::class);

$container->autowire(SqliteClient::class);

$container->autowire(TokenStorage::class);
