<?php

namespace App\Entities;

class BaseEntity
{
    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function setProperty(string $name, $value): self
    {
        $this->$name = $value;
    }
}