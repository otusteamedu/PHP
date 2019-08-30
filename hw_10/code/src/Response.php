<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class Response
{
    private $body;
    private $headers;

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    public function setResponse(string $response): void
    {
        $this->body = $response;
    }

    public function addHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function addCode(int $code): void
    {
        http_response_code($code);
    }

    private function sendHeaders(): void
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }
    }

    private function sendBody(): void
    {
        echo $this->body;
    }
}