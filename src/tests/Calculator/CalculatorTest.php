<?php

namespace App\Tests\Calculator;

use App\Calculator\Calculator;
use App\Calculator\OperationInterface;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAcceptAnyOperationInConstructor()
    {
        $operationMock = $this->createMock(OperationInterface::class);
        $this->assertInstanceOf(Calculator::class, new Calculator($operationMock));
    }

    /**
     * @test
     */
    public function shouldExecuteOperation()
    {
        $a = 1;
        $b = 2;
        $operationMock = $this->getMockBuilder(OperationInterface::class)
            ->setMethods(['execute'])
            ->getMock();
        $operationMock
            ->expects($this->once())
            ->method('execute')
            ->with($a, $b)
            ->willReturn(3);
        $calculator = new Calculator($operationMock);
        $this->assertEquals(3, $calculator->calculate($a, $b));
    }
}
