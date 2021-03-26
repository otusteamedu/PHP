<?php

namespace App\Models\DTO;

abstract class DTO
{
    public function asArray()
    {
        // TODO
        return (array)$this;
    }
}