<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use App\App;
use Codeception\Test\Unit;

class AppTest extends Unit
{
    protected UnitTester $tester;

    public function testConstructor(): void
    {
        new App();
    }

    public function testGetEnv(): void
    {
        new App();
        $this->assertEquals('dev', App::getEnv());
    }
}
