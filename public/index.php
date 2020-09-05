<?php

require '../vendor/autoload.php';

use Skytest\HttpKernel\DI\Injector;
use Skytest\HttpKernel\MiddlewareChain;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\RouteResolver;

$request = Request::createFromGlobals();

define('ROOT_PATH', __DIR__ . '/../');

$routeResolver = new RouteResolver(new Injector());

[$controller, $args] = $routeResolver->getController($request);

$response = $controller(...$args);

$middlewareChain = new MiddlewareChain();

$response = $middlewareChain->handle($request, $response);

$response->flush();
