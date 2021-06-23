<?php

declare(strict_types=1);

namespace App\Framework\Http;

class Response implements ResponseInterface
{
    private int    $statusCode;
    private string $content;

    public function __construct(int $statusCode, string $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        echo $this->content;
    }
}