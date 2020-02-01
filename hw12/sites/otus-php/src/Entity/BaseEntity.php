<?php

declare(strict_types=1);

namespace App\Entity;

class BaseEntity
{
    public function setProperty(string $name, $value)
    {
        $this->$name = $value;
    }
}