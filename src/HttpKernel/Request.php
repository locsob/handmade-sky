<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

class Request
{
    private UrlData $uri;

    private array $post;

    private array $get;

    private array $server;

    public static function createFromGlobals(): self
    {
        $self = new self();

        $self->get = $_GET;
        $self->post = $_POST;
        $self->server = $_SERVER;
        $self->uri = new UrlData(
            $_SERVER['SERVER_NAME'],
            (int) $_SERVER['SERVER_PORT'],
            $_SERVER['PATH_INFO'],
            $_SERVER['REQUEST_METHOD']
        );

        return $self;
    }
}
