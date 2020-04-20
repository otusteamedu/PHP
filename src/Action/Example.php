<?php

namespace App\Action;

use App\Responce;

class Example
{
    public static function get(): Responce
    {
        return new Responce('Example');
    }
}
