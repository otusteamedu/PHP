<?php

namespace App\Core;

use App\Api\ApplicationInterface;
use App\Api\ConfigInterface;

abstract class BaseApplication implements ApplicationInterface
{
    protected ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    abstract public function run(): void;

}