<?php

namespace Otus;

class Config
{
    private array $config;

    public function __construct(string $name)
    {
        $this->config = require $_SERVER['DOCUMENT_ROOT'].'/../config/'.$name.'.php';
    }

    public function set(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}
