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
     */
    public function canMultiply() :void
    {
        $calc = new Calc(new Multiplication(2,3));
        $this->assertEquals(6, $calc->doMath());
    }

    /**
     * @test
     */
    public function canSubtract()
    {
        $calc = new Calc(new Subtraction(5,3));
        $this->assertEquals(2, $calc->doMath());
    }

    /**
     * @test
     */
    public function canAdd()
    {
        $calc = new Calc(new Addition(5,3));
        $this->assertEquals(8, $calc->doMath());
    }

    /**
     * @test
     */
    public function canDivision()
    {
        $calc = new Calc(new Division(6,3));
        $this->assertEquals(2, $calc->doMath());
    }

    /**
     * @test
     */
    public function canUseOnlyInt()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Calc(new Division(6.2,3));
    }
}
