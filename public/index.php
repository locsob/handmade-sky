<?php

require '../vendor/autoload.php';

use Skytest\HttpKernel\MiddlewareChain;
use Skytest\HttpKernel\Request;
use Skytest\HttpKernel\RouteResolver;

$request = Request::createFromGlobals();

$routeResolver = new RouteResolver();

[$controller, $args] = $routeResolver->getController($request);

$response = $controller(...$args);

$middlewareChain = new MiddlewareChain();

$response = $middlewareChain->handle($request, $response);

$response->flush();
