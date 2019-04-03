<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 17:00
 */

namespace HW5_1;


class ProdOperation implements Operation
{
    public function calculate(Stack $stack):void
    {
        $b = $stack->pop();
        $a = $stack->pop();
        $result = $a * $b;
        $stack->push($result);
    }
}