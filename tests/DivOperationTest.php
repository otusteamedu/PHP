<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:50
 */

namespace HW5_1;

class DivOperationTest extends OperationBaseTest
{
    /**
     * @return array
     */
    public function operands(): array
    {
        return [
            ['a' => 1, 'b' => 1, 'r' => 1 / 1],
            ['a' => 3, 'b' => -1, 'r' => 3 / -1],
            ['a' => -3, 'b' => 5, 'r' => -3 / 5],
            ['a' => -2, 'b' => 4, 'r' => -2 / 4],
            ['a' => 0, 'b' => 2, 'r' => 0 / 2],
        ];
    }

    /**
     * @dataProvider operands
     * @param int $a
     * @param int $b
     * @param float $r
     */
    public function testCalculate(int $a, int $b, float $r): void
    {
        $stack = $this->getStack($a, $b);
        $op = new DivOperation();
        $op->calculate($stack);
        self::assertEquals($r, $stack->pop());
        self::assertTrue($stack->isEmpty());
    }

    /**
     *
     */
    public function testDivideToZero(): void
    {
        $stack = $this->getStack(1, 0);
        $op = new DivOperation();
        $this->expectException('DivisionByZeroError');
        $op->calculate($stack);
    }
}
