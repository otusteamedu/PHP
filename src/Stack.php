<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 02.04.19
 * Time: 15:46
 */

namespace HW5_1;

interface Stack
{
    public function isEmpty();

    public function pop();

    public function push($value);
}
