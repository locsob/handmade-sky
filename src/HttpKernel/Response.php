<?php

declare(strict_types=1);

namespace Skytest\HttpKernel;

class Response
{
    private array $headers;

    private string $content;

    private int $status;

    /**
     * Response constructor.
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $content, int $status = 200, array $headers = [])
    {
        $this->headers = $headers;
        $this->content = $content;
        $this->status = $status;
    }

    public function flush()
    {
        ob_start();

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;

        ob_end_flush();
    }
}
