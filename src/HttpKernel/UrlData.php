<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

class UrlData
{
    private string $serverName;

    private int $port;

    private string $path;

    private string $method;

    /**
     * UrlData constructor.
     * @param string $serverName
     * @param int $port
     * @param string|null $path
     * @param string $method
     */
    public function __construct(string $serverName, int $port, ?string $path, string $method)
    {
        $this->serverName = $serverName;
        $this->port = $port;
        $this->path = $path ?? '/';
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getDomain(): string
    {
        return sprintf('%s:%s', $this->serverName, $this->port);
    }
}
