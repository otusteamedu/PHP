<?php

namespace Task;

use Core\AppConfig;

abstract class TaskController
{
    protected AppConfig $appConfig;

    public function __construct(AppConfig $appConfig)
    {
        $this->appConfig = $appConfig;
    }

    abstract public function run();
}