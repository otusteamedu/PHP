<?php

namespace App\Models;

abstract class BaseModel
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}
