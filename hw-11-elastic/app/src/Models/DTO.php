<?php

namespace Models;

abstract class DTO
{
    public string $tableName;

    public function asArray()
    {
        return (array)$this;
    }
}