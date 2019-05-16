<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\CalculationStrategyDivide;
use timga\calculator\Exceptions\DivisionByZeroException;

class CalculationStrategyDivideTest extends TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new CalculationStrategyDivide();
    }

    protected function tearDown()
    {
        $this->strategy = null;
    }

    public function addDataProvider()
    {
        return [
            [4,2,2],
            [-4,2,-2],
            [4,-2,-2],
            [-4,-2,2],
            [2,4,0.5],
            [-2,4,-0.5],
            [2,-4,-0.5],
            [-2,-4,0.5],
            [0,1,0],
        ];
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testDivideOperation($valueA, $valueB, $expected)
    {
        $result = $this->strategy->calculate($valueA, $valueB);
        self::assertEquals($result, $expected);
    }

    public function testThrowDivisionByZeroException()
    {
        self::expectException(DivisionByZeroException::class);
        $this->strategy->calculate(1, 0);
    }
}