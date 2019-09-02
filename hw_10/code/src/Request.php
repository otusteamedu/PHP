<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class Request
{
    private $rowBody;
    private $headers;

    public function __construct()
    {
        $this->headers = getallheaders();
        $this->rowBody = $_REQUEST;
    }

    public function getBody(): ?array
    {
        if ($this->isContentLengthEqual()) {
            return $this->rowBody;
        }

        return null;
    }

    private function isContentLengthEqual(): bool
    {
        $requestBodyLength = strlen(file_get_contents('php://input'));
        $requestBodyLengthFromHeader = (int) $this->headers['Content-Length'];
        return $requestBodyLength === $requestBodyLengthFromHeader;
    }
}