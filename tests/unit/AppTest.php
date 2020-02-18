<?php

use App\App;
use Codeception\Test\Unit;

class AppTest extends Unit
{
    protected UnitTester $tester;

    public function testHello(): void
    {
        $result = App::run();
        $this->assertEquals($result, 'Hello, world!');
    }
}
