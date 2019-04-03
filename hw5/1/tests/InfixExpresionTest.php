<?php


use HW5_1\InfixExpresion;
use PHPUnit\Framework\TestCase;

class InfixExpresionTest extends TestCase
{

    public function testToPostfix1()
    {
        $expr = new InfixExpresion('1 + ( 3 - 4)');
        self::assertEquals('1 3 4 - +', $expr->toPostfix());
    }


    public function testToPostfix2()
    {
        $expr = new InfixExpresion('13 + 16 * 17');
        self::assertEquals('13 16 17 * +', $expr->toPostfix());
    }

    public function testToPostfix3()
    {
        $expr = new InfixExpresion('11 % 12 *13');
        self::assertEquals('11 12 % 13 *', $expr->toPostfix());
    }

    public function testToPostfix4()
    {
        $expr = new InfixExpresion('1 + 2 * ( 3 -4 / ( 5 + 6 ) )');
        self::assertEquals('1 2 3 4 5 6 + / - * +', $expr->toPostfix());
    }
}
