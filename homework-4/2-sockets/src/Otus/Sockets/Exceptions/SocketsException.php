<?php

namespace Otus\Sockets\Exceptions;

use RuntimeException;

class SocketsException extends RuntimeException
{
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? $this->getSocketLastError());
    }

    private function getSocketLastError(): string
    {
        return socket_strerror(socket_last_error());
    }
}
