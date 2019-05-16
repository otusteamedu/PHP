<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\CalculationStrategyMultiply;

class CalculationStrategyMultiplyTest extends TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new CalculationStrategyMultiply();
    }

    protected function tearDown()
    {
        $this->strategy = null;
    }

    public function addDataProvider()
    {
        return [
            [2,3,6],
            [-2,3,-6],
            [2,-3,-6],
            [-2,-3,6],
            [0,0,0],
            [0,4,0],
            [4,0,0],
            [0,-4,0],
        ];
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testMultiplyOperation($a, $b, $expected)
    {
        $result = $this->strategy->calculate($a, $b);
        self::assertEquals($expected, $result);
    }
}