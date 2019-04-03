<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:51
 */

namespace HW5_1;

class ModOperation implements Operation
{

    public function calculate(Stack $stack): float
    {
        $b = $stack->pop();
        $a = $stack->pop();
        $result = $a % $b;
        $stack->push($result);
        return $result;
    }
}