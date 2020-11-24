<?php

namespace Otus\Exceptions;

use Throwable;

class ConsoleExceptionHandler implements ExceptionHandlerContract
{
    public function render(Throwable $throwable)
    {
        echo $throwable->getMessage() . PHP_EOL;
    }
}