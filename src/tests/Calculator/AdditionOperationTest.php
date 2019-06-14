<?php

namespace App\Tests\Calculator;

use App\Calculator\AdditionOperation;
use PHPUnit\Framework\TestCase;

class AdditionOperationTest extends TestCase
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
        $operation = new AdditionOperation();
        $this->assertEquals($sum, $operation->execute($a, $b));
    }

    public function executeProvider()
    {
        return [
            [1.0, 1.0, 2.0],
            [4.0, 2.0, 6.0],
            [7.0, 2.0, 9.0],
            [-1.0, -1.0, -2.0],
            [-100.0, -90.0, -190.0]
        ];
    }
}
