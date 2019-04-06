<?php

namespace HW5_1;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{

    /**
     * @return array
     */
    public function variants(): array
    {
        return [
            ['exp' => '1 + 2 * ( 3 -4 / ( 5 + 6 ) )', 'result' => 6.272727273],
            ['exp' => '13 + 16 * 17', 'result' => 285],
            ['exp' => '11 % 12 *13', 'result' => 143],
            ['exp' => '1', 'result' => 1],
        ];
    }

    /**
     * @dataProvider variants
     *
     * @param $exp
     * @param $result
     */
    public function testCalculate($exp, $result): void
    {
        $calc = new Calculator($exp);
        $res = $calc->calculate();
        self::assertEqualsWithDelta($result, $res, 0.0001);
    }
}
