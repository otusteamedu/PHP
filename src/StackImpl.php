<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:48
 */

namespace HW5_1;

use SplStack;

class StackImpl extends SplStack implements Stack
{
    public function print()
    {
        var_dump($this);
    }
}
