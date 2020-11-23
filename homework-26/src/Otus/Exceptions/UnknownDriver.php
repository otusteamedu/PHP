<?php

namespace Otus\Exceptions;

use Exception;

class UnknownDriver extends Exception
{
    public function __construct(string $connection)
    {
        parent::__construct('Unknown driver ' . $connection);
    }
}