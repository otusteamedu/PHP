<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:51
 */

namespace HW5_1;

use DivisionByZeroError;

class DivOperation implements Operation
{

    public function calculate(Stack $stack): void
    {
        $b = $stack->pop();
        if ($b === 0) {
            throw  new DivisionByZeroError('Division By Zero');
        }
        $a = $stack->pop();
        $result = $a / $b;
        $stack->push($result);
    }
}