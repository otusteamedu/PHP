<?php

namespace crazydope\calculator\tests;

use crazydope\calculator\Exceptions\ExpressionNotFoundException;
use crazydope\calculator\Expression;
use crazydope\calculator\ExpressionList;
use PHPUnit\Framework\TestCase;

class ExpressionListTest
    extends TestCase
{
    public function testShouldThrowExpressionNotFoundException(): void
    {
        $this->expectException(ExpressionNotFoundException::class);

        $list =  new ExpressionList();
        $list->get(1);
    }

    public function testCount(): void
    {
        $list =  new ExpressionList();
        $list->add(new Expression(0, 2, '+'));

        $this->assertEquals(1, $this->count());
    }
}