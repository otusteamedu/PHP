<?php

namespace crazydope\theater\Job\Adapter;

use crazydope\theater\Model\MessageInterface;

interface AdapterInterface
{
    public function publish(string $message): void;

    public function consume(callable $callback, int $maxJobs = 1): void;
}