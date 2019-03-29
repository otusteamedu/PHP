<?php

use Fdor\Calc;
use Fdor\SimpleSumStrategy;
use Fdor\RoundSumStrategy;
use PHPUnit\Framework\TestCase;

/**
 * Class CalcTest
 */
class CalcTest extends TestCase
{
    public function testCalc(): void
    {
        $a = 5.2;
        $b = 3.7;

        $simpleSumStrategy = new SimpleSumStrategy();
        $roundSumStrategy = new RoundSumStrategy();
        $roundSumStrategy->setSimpleSumStrategy($simpleSumStrategy);

        $calc = new Calc($simpleSumStrategy);
        $this->assertEquals($calc->execute($a, $b), 8.9);

        $calc->setStrategy($roundSumStrategy);
        $this->assertEquals($calc->execute($a, $b), 9);
    }
}
