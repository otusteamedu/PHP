<?php

namespace HW5_1;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testCalculate1()
    {
        $exp = '1 + 2 * ( 3 -4 / ( 5 + 6 ) )';
        $calc = new Calculator($exp);
        $res = $calc->calculate();
        self::assertEqualsWithDelta(6.272727273, $res, 0.0001);
    }

    public function testCalculate2()
    {
        $exp = '13 + 16 * 17';
        $calc = new Calculator($exp);
        $res = $calc->calculate();
        self::assertEqualsWithDelta(285, $res, 0.0001);
    }

    public function testCalculate3()
    {
        $exp = '11 % 12 *13';
        $calc = new Calculator($exp);
        $res = $calc->calculate();
        self::assertEqualsWithDelta(143, $res, 0.0001);
    }

    public function testCalculate4()
    {
        $exp = '1';
        $calc = new Calculator($exp);
        $res = $calc->calculate();
        self::assertEqualsWithDelta(1, $res, 0.0001);
    }
}
