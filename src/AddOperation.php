<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:47
 */

namespace HW5_1;

class AddOperation implements Operation
{
    public function calculate(Stack $stack): void
    {
        $a = $stack->pop();
        $b = $stack->pop();
        $result = $a + $b;
        $stack->push($result);
    }
}
