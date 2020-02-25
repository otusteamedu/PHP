<?php

use App\App;
use Codeception\Test\Unit;
use Whoops\Run as ErrorHandler;

class AppTest extends Unit
{
    protected UnitTester $tester;

    public function testLoadDotEnv(): void
    {
        putenv('APP_ENV');
        $method = $this->tester::getReflectionMethod(App::class, 'loadDotEnv');
        $method->invokeArgs(null, []);
        $this->assertFalse(getenv('APP_ENV'));
        putenv('APP_ENV=dev');
    }

    public function testSetErrorHandler(): void
    {
        $method = $this->tester::getReflectionMethod(App::class, 'setErrorHandler');
        $method->invokeArgs(null, []);
        $prev_handler = set_error_handler(fn($code, $message) => false);
        $this->assertInstanceOf(ErrorHandler::class, $prev_handler[0]);
        restore_error_handler();
        restore_error_handler();
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(App::class, new App());
    }

    public function testRun(): void
    {
        (new App())->run();
    }
}
