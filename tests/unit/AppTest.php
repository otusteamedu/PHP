<?php

use App\App;
use Codeception\Test\Unit;
use Whoops\Run as ErrorHandler;

class AppTest extends Unit
{
    protected UnitTester $tester;

    public function testSetEnv(): void
    {
        unset($_ENV['APP_ENV'], $_SERVER['APP_ENV']);
        putenv('APP_ENV');
        $method = $this->tester::getReflectionMethod(App::class, 'setEnv');
        $method->invokeArgs(null, []);
        $this->assertContains(getenv('APP_ENV'), ['prod', 'dev']);
        putenv('APP_ENV=dev');
    }

    public function testSetErrorRunner(): void
    {
        putenv('APP_ENV=dev');
        $method = $this->tester::getReflectionMethod(App::class, 'setErrorRunner');
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
