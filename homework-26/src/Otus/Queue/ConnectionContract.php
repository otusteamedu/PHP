<?php

namespace Otus\Queue;

use Otus\Config\ConfigContract;

interface ConnectionContract
{
    public function connect(ConfigContract $config): QueueContract;
}