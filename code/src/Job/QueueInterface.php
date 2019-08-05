<?php

namespace crazydope\theater\Job;

use crazydope\theater\Model\MessageInterface;

interface QueueInterface
{
    public function publish(string $message): void;

    public function consume(callable $callback): void;
}