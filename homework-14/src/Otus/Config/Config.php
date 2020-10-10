<?php

namespace Otus\Config;

class Config implements ConfigContract
{
    private array $items;

    public function __construct(string $path)
    {
        $this->items = require $path;
    }

    public function set(string $key, $value): self
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function get(string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }
}
