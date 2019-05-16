<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\CalculationStrategyPow;

class CalculationStrategyPowTest extends TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new CalculationStrategyPow();
    }

    protected function tearDown()
    {
        $this->strategy = null;
    }

    public function addDataProvider()
    {
        return [
            [2,3,8],
            [10,-2,0.01],
            [-4,2,16],
            [-2,3,-8],
        ];
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testPowOperation($a, $b, $expected)
    {
        $result = $this->strategy->calculate($a, $b);
        self::assertEquals($expected, $result);
    }
}