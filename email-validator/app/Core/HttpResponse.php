<?php


namespace App\Core;

use App\Api\ResponseInterface;

class HttpResponse implements ResponseInterface
{
    private int $httpCode = 200;
    private string $body;

    public function send(): void
    {
        http_response_code($this->httpCode);
        echo $this->body;
    }

    public function setHttpCode(int $code): self
    {
        $this->httpCode = $code;
        return $this;
    }

    public function setBody(string $string): self
    {
        $this->body = $string;
        return $this;
    }


}