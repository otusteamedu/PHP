<?php

declare(strict_types=1);

namespace Socket\Ruvik;

use Socket\Ruvik\Exception\RuntimeException;

class Environment
{
    private static self $instance;
    private string $env;

    private function __construct(string $env)
    {
        $this->env = $env;
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            throw new RuntimeException('Not initialized Environment');
        }
        return self::$instance;
    }

    public static function initEnv(string $env): void
    {
        if (empty($env)) {
            throw new RuntimeException('Environment is setting empty');
        }
        self::$instance = new self($env);
    }

    public function getEnv(): string
    {
        return $this->env;
    }
}
