<?php

namespace Dev;

use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorRunner;

class ErrorHandler
{
    public static function register(): void
    {
        (new ErrorRunner())
            ->pushHandler(
                new PlainTextHandler()
            )
            ->register();
    }
}
