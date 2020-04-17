<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use App\ErrorHandler;
use Codeception\Test\Unit;
use Whoops\Run as ErrorRunner;

class ErrorHandlerTest extends Unit
{
    protected UnitTester $tester;

    public function testSetErrorHandler(): void
    {
        putenv('APP_ENV=dev');
        new ErrorHandler();
        $prev_handler = set_error_handler(fn($code, $message) => false);
        $this->assertInstanceOf(ErrorRunner::class, $prev_handler[0]);
        restore_error_handler();
        restore_error_handler();
    }
}
