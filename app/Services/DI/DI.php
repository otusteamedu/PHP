<?php

namespace App\Services\DI;

use App\Models\IModel;

class DI
{
    public static function getModel($class): IModel
    {
        return new $class();
    }
}