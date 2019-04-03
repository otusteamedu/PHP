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
     * @dataProvider provider
     */
    public function canMultiply($a, $b) :void
    {
        $calc = new Calc(new Multiplication($a, $b));
        $this->assertEquals($a * $b, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canSubtract($a, $b)
    {
        $calc = new Calc(new Subtraction($a,$b));
        $this->assertEquals($a - $b, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canAdd($a, $b)
    {
        $calc = new Calc(new Addition($a, $b));
        $this->assertEquals($a + $b, $calc->doMath());
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canDivision($a, $b)
    {
        if (is_float($a / $b)) {
            $this->expectException(\InvalidArgumentException::class);
        }
        $calc = new Calc(new Division($a, $b));
        $this->assertEquals($a / $b, $calc->doMath());
    }

    /**
     * @test
     */
    public function canUseOnlyInt()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Calc(new Division(6.2,3));
    }

    /**
     * @test
     */
    public function divisionByZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $calc = new Calc(new Division(6,0.0));
        $this->assertEquals(2, $calc->doMath());
    }

    public function provider()
    {
        return array(
            array(1, 2, 3),
            array(4, 5, 6),
            array(7, 8, 9),
            array(10, 11, 12)
        );
    }
}
