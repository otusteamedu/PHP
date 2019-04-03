<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:47
 */

namespace HW5_1;


class MinOperation implements Operation
{

    public function calculate(Stack $stack): void
    {
        $b = $stack->pop();
        $a = $stack->pop();
        $result = $a - $b;
        $stack->push($result);
    }
}