<?php

namespace App\Exceptions;

use Throwable;

class WrongModelPropertyMappingException extends \Exception
{
    public function __construct(string $className)
    {
        parent::__construct("Wrong model properties mapping exception at: {$className} class!");
    }
}
