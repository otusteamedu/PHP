<?php

declare(strict_types=1);

namespace App\Framework\Http;

class Response implements ResponseInterface
{
    private int    $statusCode;
    private string $content;
    private array  $headers = [];

    public function __construct(int $statusCode, $content)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    protected function addHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function send(): void
    {
        $this->sendHeaders();
        http_response_code($this->statusCode);

        echo $this->content;
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, false, $this->statusCode);
        }
    }
}