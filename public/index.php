<?php

require '../vendor/autoload.php';

use Skytest\HttpKernel\DI\Injector;
use Skytest\HttpKernel\Middleware\MiddlewareChain;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\RouteResolver;

session_start();

$request = Request::createFromGlobals();

define('ROOT_PATH', __DIR__ . '/../');

$injector = new Injector();

$preFilters = new MiddlewareChain($injector->resolveArray(require_once ROOT_PATH . 'config/pre-filter.php'));

[$request, $response] = $preFilters->handleRequest($request);

if (!$response) {
    $routeResolver = new RouteResolver($injector);

    [$controller, $args] = $routeResolver->getController($request);

    $response = $controller(...$args);
}

$response->flush();
