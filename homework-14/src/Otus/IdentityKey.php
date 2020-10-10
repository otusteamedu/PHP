<?php

namespace Otus;

class IdentityKey
{
    private string $key;

    public function __construct(string $class, string $primaryKey)
    {
        $this->key = $class.$primaryKey;
    }

    public static function make(string $class, $primaryKey): self
    {
        return new self($class, $primaryKey);
    }

    public function get(): string
    {
        return $this->key;
    }
}
