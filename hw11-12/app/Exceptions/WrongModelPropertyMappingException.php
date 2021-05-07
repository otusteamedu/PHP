<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class WrongModelPropertyMappingException extends \Exception
{
    #[Pure]
    public function __construct(string $className)
    {
        parent::__construct("Wrong model properties mapping exception at: {$className} class!");
    }
}
