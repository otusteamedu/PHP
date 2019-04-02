<?php

use PHPUnit\Framework\TestCase;
use nvggit\Calculator;
use nvggit\Add;
use nvggit\Substract;
use nvggit\Multiply;
use nvggit\Divide;

class TestCalculator extends TestCase
{
    public function testAll()
    {
        $values = [3.0, 1.5];

        $this->add($values, 4.5);
        $this->sub($values, 1.5);
        $this->mul($values, 4.5);
        $this->div($values, 2.0);
    }

    /**
     * @param array $input
     * @param $expected
     */
    public function add(array $input, $expected)
    {
        $calculator = new Calculator(new Add());
        $result = $calculator->exec($input[0], $input[1]);

        $this->assertSame($expected, $result);
    }

    /**
     * @param array $input
     * @param $expected
     */
    public function sub(array $input, $expected)
    {
        $calculator = new Calculator(new Substract());
        $result = $calculator->exec($input[0], $input[1]);

        $this->assertSame($expected, $result);
    }

    /**
     * @param array $input
     * @param $expected
     */
    public function mul(array $input, $expected)
    {
        $calculator = new Calculator(new Multiply());
        $result = $calculator->exec($input[0], $input[1]);

        $this->assertSame($expected, $result);
    }

    /**
     * @param array $input
     * @param $expected
     */
    public function div(array $input, $expected)
    {
        $calculator = new Calculator(new Divide());
        $result = $calculator->exec($input[0], $input[1]);

        $this->assertSame($expected, $result);
    }
}