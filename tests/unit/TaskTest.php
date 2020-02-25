<?php

use App\Task;
use Codeception\Test\Unit;

class TaskTest extends Unit
{
    protected UnitTester $tester;

    public function testIsStringValid(): void
    {
        $method = $this->tester::getReflectionMethod(Task::class, 'isStringValid');

        $res = $method->invokeArgs(null, ['a']);
        $this->assertTrue($res);

        $res = $method->invokeArgs(null, ['(a)']);
        $this->assertTrue($res);

        $res = $method->invokeArgs(null, ['(a)']);
        $this->assertTrue($res);

        $res = $method->invokeArgs(null, ['aa(aa)aa']);
        $this->assertTrue($res);

        $res = $method->invokeArgs(null, ['(((a)(a))(()()))']);
        $this->assertTrue($res);

        $res = $method->invokeArgs(null, ['']);
        $this->assertFalse($res);

        $res = $method->invokeArgs(null, ['(']);
        $this->assertFalse($res);

        $res = $method->invokeArgs(null, ['((a)']);
        $this->assertFalse($res);

        $res = $method->invokeArgs(null, ['(()()()()))((((()()()))(()()()(((()))))))']);
        $this->assertFalse($res);

        $res = $method->invokeArgs(null, [')(']);
        $this->assertFalse($res);
    }

    public function testRun(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['string'] = '()';
        $responce = Task::run();
        $this->assertSame('Ok', $responce);
    }
}
