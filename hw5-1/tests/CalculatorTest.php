<?php

namespace timga\calculator\tests;

use PHPUnit\Framework\TestCase;
use timga\calculator\Calculator;
use timga\calculator\Exceptions\CalcActionNotExistsException;

class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp()
    {
        $this->calculator = new Calculator();
    }

    protected function tearDown()
    {
        $this->calculator = null;
    }

    public function addDataProvider()
    {
        return [
            ['add','timga\calculator\CalculationStrategyAdd'],
            ['subtract','timga\calculator\CalculationStrategySubtract'],
            ['divide','timga\calculator\CalculationStrategyDivide'],
            ['multiply','timga\calculator\CalculationStrategyMultiply'],
            ['pow','timga\calculator\CalculationStrategyPow'],
        ];
    }

    public function testIncorrectCalcActionTrowException()
    {
        self::expectException(CalcActionNotExistsException::class);
        $this->calculator->chooseStrategy('addd');
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testCorrectCalcActionDontTrowException($action, $expectedInstanceOf)
    {
        $instance = $this->calculator->chooseStrategy($action);
        self::assertInstanceOf($expectedInstanceOf, $instance);
    }
}