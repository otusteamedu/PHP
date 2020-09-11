<?php

namespace Otus\Sockets\Exceptions;

class UnsupportedApplicationTypeException extends SocketsException
{
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? 'Unsupported application type');
    }
}
