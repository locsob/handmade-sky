<?php

use Skytest\Db\SqliteClient;
use Skytest\HttpKernel\DI\Container;
use Skytest\Model\UserGateway;

/** @var Container $container */

$container->autowire(UserGateway::class);

$container->autowire(SqliteClient::class);
