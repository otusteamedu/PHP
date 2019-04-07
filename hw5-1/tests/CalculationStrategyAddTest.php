<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\CalculationStrategyAdd;

class CalculationStrategyAddTest extends TestCase
{
    private $strategy;

    protected function setUp()
    {
        $this->strategy = new CalculationStrategyAdd();
    }

    protected function tearDown()
    {
        $this->strategy = null;
    }

    public function addDataProvider()
    {
        return array(
            array(2,3,5),
            array(0,0,0),
            array(-1,-2,-3),
            array(0,-2,-2),
            array(-5,0,-5),
            array(0,12,12),
            array(13,0,13),
        );
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testAddOperation($a, $b, $expected)
    {
        $result = $this->strategy->calculate($a,$b);
        self::assertEquals($expected,$result);
    }
}