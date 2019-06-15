#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Calc\Calculate;
use Calc\SumStrategy;
use PHPUnit\Framework\TestCase;

class CalcTest extends TestCase
{
    public function testCalc(): void
    {
	$a = 6.2;
        $b = 2.2;
	$sumStrategy = new SumStrategy();
	$divideStrategy = new DivideStrategy();

	$calc = new Calc($sumStrategy);
	$calc->setStrategy($sumStrategy);
	$this->assertEquals($calc->execute($a, $b), 8.4);


	$a = 6;
        $b = 2;
	$calc->setStrategy($divideStrategy);
	$this->assertEquals($calc->execute($a, $b), 3);

	$a = 3;
        $b = 0;
	$calc->setStrategy($divideStrategy);
	$this->assertEquals($calc->execute($a, $b), false);

    }
}
