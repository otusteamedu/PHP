<?php

namespace nvggit;

use PHPUnit\Framework\TestCase;

/**
 * Class CalculateTest
 * @package nvggit
 */
class CalculateTest  extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ["add",3.0, 1.5, 4.5],
            ["div", 3.0, 1.5, 2.0],
            ["mul", 2.0, 5.5, 11.0],
            ["sub", 2.0, 5.5, -3.5],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testExec($operation, $a, $b, $expected)
    {
        $calculator = new Calculator();
        $this->assertSame($expected, $calculator->exec($operation, $a, $b));
    }

    /**
     *    @expectedException \DivisionByZeroError
     */
    public function testDivideZero()
    {
        $calculator = new Calculator();
        $calculator->exec("div", 1.0, 0);
    }
}