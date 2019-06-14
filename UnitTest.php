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
	$a = 2.1;
        $b = 6.7;
	$sumStrategy = new SumStrategy();
	$divideStrategy = new DivideStrategy();

	$calc = new Calc($sumStrategy);
	$calc->setStrategy($sumStrategy);
	$this->assertEquals($calc->execute($a, $b), 4);

	$calc->setStrategy($divideStrategy);
	$this->assertEquals($calc->execute($a, $b), 4);

    }
}