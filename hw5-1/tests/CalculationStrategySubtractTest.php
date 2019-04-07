<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\CalculationStrategySubtract;


class CalculationStrategySubtractTest extends TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new CalculationStrategySubtract();
    }

    protected function tearDown()
    {
        $this->strategy = null;
    }

    public function addDataProvider()
    {
        return array(
            array(5,3,2),
            array(4,7,-3),
            array(0,0,0),
            array(-5,-3,-2),
            array(-3,-5,2),
            array(-7,5,-12),
            array(5,-7,12),
            array(-5,7,-12),
            array(7,-5,12),
        );
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testSubtractOperation($a, $b, $expected)
    {
        $result = $this->strategy->calculate($a,$b);
        self::assertEquals($expected, $result);
    }
}