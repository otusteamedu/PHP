<?php

namespace App\Tests\Calculator;

use App\Calculator\AdditionOperation;
use App\Calculator\MultiplicationOperation;
use PHPUnit\Framework\TestCase;

class MultiplicationOperationTest extends TestCase
{
    /**
     * @test
     * @dataProvider executeProvider
     * @param $a
     * @param $b
     * @param $sum
     * @throws \App\Exception\CalculationException
     * @throws \App\Exception\InputException
     */
    public function testExecute($a, $b, $sum)
    {
        $operation = new MultiplicationOperation();
        $this->assertEquals($sum, $operation->execute($a, $b));
    }

    public function executeProvider()
    {
        return [
            [1.0, 1.0, 1.0],
            [4.0, 2.0, 8.0],
            [7.0, 2.0, 14.0],
            [-1.0, -1.0, 1.0],
            [-100.0, -90.0, 9000.0]
        ];
    }
}
