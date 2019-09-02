<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

use mysql_xdevapi\Exception;

class Response
{
    public const RESPONSE_CODES = [200, 400, 500]; // and etc

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
        if (in_array($code, self::RESPONSE_CODES))
        {
            http_response_code($code);
        } else {
            throw new Exception("Unknown response code $code");
        }
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