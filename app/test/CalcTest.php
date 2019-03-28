<?php

use Fdor\Calc;
use Fdor\Strategy1;
use Fdor\Strategy2;
use PHPUnit\Framework\TestCase;

/**
 * Class CalcTest
 */
class CalcTest extends TestCase
{
    public function testSum(): void
    {
        $a = 5.2;
        $b = 3.7;

        $strategy1 = new Strategy1();
        $strategy2 = new Strategy2();

        $calc1 = new Calc($strategy1);
        $calc2 = new Calc($strategy2);

        $this->assertEquals($calc1->sum($a, $b), 8.9);
        $this->assertEquals($calc2->sum($a, $b), 9);
    }
}
