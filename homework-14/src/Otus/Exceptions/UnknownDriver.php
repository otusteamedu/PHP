<?php

namespace Otus\Exceptions;

use RuntimeException;

class UnknownDriver extends RuntimeException
{
    protected $message = 'Driver is unknown';

    public function __construct(string $driver = null)
    {
        parent::__construct("Driver '{$driver}' is unknown".PHP_EOL);
    }
}
