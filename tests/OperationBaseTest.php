<?php

namespace HW5_1;

use PHPUnit\Framework\TestCase;

abstract class OperationBaseTest extends TestCase
{
    /**
     * @param int $a
     * @param int $b
     * @return Stack
     */
    public function getStack(int $a, int $b): Stack
    {
        $stack = new StackImpl();
        $stack->push($a);
        $stack->push($b);
        return $stack;
    }
}
