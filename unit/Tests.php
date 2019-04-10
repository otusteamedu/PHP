<?php

namespace Unit;

use Calc\Calc;
use Calc\Operations\Addition;
use Calc\Operations\Division;
use Calc\Operations\Multiplication;
use Calc\Operations\Subtraction;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class Tests extends TestCase
{
    /**
     * @test
     * @dataProvider multiplyDataProvider
     */
    public function canMultiply($a, $b, $expected)
    {
        $calc = new Calc(new Multiplication($a, $b));
        $this->assertEquals($expected, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider subtractDataProvider
     */
    public function canSubtract($a, $b, $expected)
    {
        $calc = new Calc(new Subtraction($a,$b));
        $this->assertEquals($expected, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider addDataProvider
     */
    public function canAdd($a, $b, $expected)
    {
        $calc = new Calc(new Addition($a, $b));
        $this->assertEquals($expected, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider divisionDataProvider
     */
    public function canDivide($a, $b, $expected)
    {
        $calc = new Calc(new Division($a, $b));
        $this->assertEquals($expected, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider onlyIntDataProvider
     */
    public function canUseOnlyIntThrownException($a, $b)
    {
        $this->expectException(\InvalidArgumentException::class);
        new Calc(new Division($a, $b));
    }

    /**
     * @test
     * @dataProvider divisionZeroDataProvider
     */
    public function divisionByZeroThrownException($a, $b, $expected)
    {
        $this->expectException(\InvalidArgumentException::class);
        $calc = new Calc(new Division($a, $b));
        $this->assertEquals($expected, $calc->doMath());
    }

    public function multiplyDataProvider()
    {
        return array(
            array(1, 2, 2),
            array(4, 5, 20),
            array(7, 8, 56)
        );
    }

    public function subtractDataProvider()
    {
        return array(
            array(5, 2, 3),
            array(10, 2, 8),
            array(7, 7, 0)
        );
    }

    public function addDataProvider()
    {
        return array(
            array(2, 3, 5),
            array(1, 7, 8),
            array(9, 4, 13)
        );
    }

    public function divisionDataProvider()
    {
        return array(
            array(4, 2, 2),
            array(8, 2, 4),
            array(6, 2, 3)
        );
    }

    public function onlyIntDataProvider()
    {
        return array(
            array(2, 3.2),
            array(4, 5.7),
            array(4, 9.1),
        );
    }

    public function divisionZeroDataProvider()
    {
        return array(
            array(5, 0, 0),
            array(9, 0, 0),
            array(14, 0, 0),
        );
    }
}
