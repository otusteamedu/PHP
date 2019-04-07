<?php

namespace nvggit;

use PHPUnit\Framework\TestCase;

/**
 * Class AddTest
 * @package nvggit
 */
class AddTest  extends TestCase
{
    public function dataProvider(): array
    {
        return [
            "div",
            "mul",
            "add",
            "sub"
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExec($operation)
    {
        $calculator = new Calculator();
        $this->assertSame(true, $calculator->canPerformOperation($operation));
    }


    /**
     *    @expectedException \Exception
     */
    public function testThrowsException(){
        $calculator = new Calculator();
        $calculator->canPerformOperation("test");
    }
}