<?php

namespace Models;

abstract class DTO
{
    public function asArray()
    {
        return (array)$this;
    }
}