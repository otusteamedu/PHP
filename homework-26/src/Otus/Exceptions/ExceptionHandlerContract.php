<?php

namespace Otus\Exceptions;

use Throwable;

interface ExceptionHandlerContract
{
    public function render(Throwable $throwable);
}