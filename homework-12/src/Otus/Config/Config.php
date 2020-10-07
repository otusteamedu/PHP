<?php

namespace Otus\Config;

class Config implements ConfigContract
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
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
