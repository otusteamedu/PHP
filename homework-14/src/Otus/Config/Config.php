<?php

namespace Otus\Config;

use Otus\Exceptions\ConfigError;
use Otus\Exceptions\ConfigNotFound;
use Throwable;

class Config implements ConfigContract
{
    private array $items;

    private static ?self $instance = null;

    private function __construct(string $configPath)
    {
        if (! file_exists($configPath)) {
            throw new ConfigError('Config not found' . PHP_EOL);
        }

        try {
            $this->items = require $configPath;
        } catch (Throwable $throwable) {
            throw new ConfigError('Error parsing config' . PHP_EOL);
        }
    }

    public static function getInstance(string $configPath = null): self
    {
        if (! self::$instance) {
            self::$instance = new self($configPath);
        }

        return self::$instance;
    }

    public function set(string $key, $value): self
    {
        $this->items[$key] = $value;

        return $this;
    }

    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->items[$key];
        }

        if (strpos($key, '.') === false) {
            return $this->items[$key] ?? $default;
        }

        $items = $this->items;
        foreach (explode('.', $key) as $segment) {
            if (is_array($items) && array_key_exists($segment, $items)) {
                $items = $items[$segment];
            } else {
                return $default;
            }
        }

        return $items;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
