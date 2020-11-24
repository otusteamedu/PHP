<?php

namespace Otus\Exceptions;

use Exception;

class FileNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('FileNotFound');
    }
}