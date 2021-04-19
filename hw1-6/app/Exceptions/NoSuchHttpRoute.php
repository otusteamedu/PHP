<?php

namespace App\Exceptions;

use Exception;

class NoSuchHttpRoute extends Exception
{
    /**
     * NoSuchHttpRoute constructor.
     *
     * @param string $message
     */
    public function __construct($message = "No such route!")
    {
        parent::__construct($message);
    }
}
