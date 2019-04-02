<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:45
 */

namespace HW5_1;


interface Operation
{
    public function calculate(Stack $stack): float ;
}