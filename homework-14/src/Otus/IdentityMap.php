<?php

namespace Otus;

class IdentityMap
{
    private static ?self $instance = null;

    private array $map = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function make(): self
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set(string $key, $value): void
    {
        if ($this->has($key)) {
            return;
        }

        $this->map[$key] = $value;
    }

    public function get(string $key)
    {
        if (! $this->has($key)) {
            return null;
        }

        return $this->map[$key];
    }

    public function delete($key): void
    {
        if (! $this->has($key)) {
            return;
        }

        unset($this->map[$key]);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->map);
    }
}
