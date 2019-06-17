<?php

namespace App\Tests\Calculator;

use App\Calculator\DivisionOperation;
use App\Exception\CalculationException;
use PHPUnit\Framework\TestCase;

class DivisionOperationTest extends TestCase
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
        $operation = new DivisionOperation();
        $this->assertEquals($sum, $operation->execute($a, $b));
    }

    public function executeProvider()
    {
        return [
            [1.0, 1.0, 1.0],
            [4.0, 2.0, 2.0],
            [7.0, 2.0, 3.5],
            [-1.0, -1.0, 1.0],
            [-90.0, -100.0, 0.9]
        ];
    }

    /**
     * @test
     * @expectedException \App\Exception\CalculationException
     * @throws \App\Exception\CalculationException
     * @throws \App\Exception\InputException
     */
    public function shouldThrowExceptionIfDivisionByZero()
    {
        $operation = new DivisionOperation();
        $operation->execute(1.0, 0.0);
    }

    /**
     * @test
     * @throws \App\Exception\InputException
     */
    public function testDivisionByZeroExceptionMessage()
    {
        try {
            $operation = new DivisionOperation();
            $operation->execute(1.0,  0.0);
        } catch (CalculationException $e) {
            $this->assertEquals('Division by zero', $e->getMessage());
        }
    }
}
