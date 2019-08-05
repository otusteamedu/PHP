<?php

namespace crazydope\theater\Job;

use crazydope\theater\Job\Adapter\AdapterInterface;
use crazydope\theater\Model\MessageInterface;

class Queue implements QueueInterface
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function publish(string $message): void
    {
        $this->adapter->publish($message);
    }

    public function consume(callable $callback): void
    {
        $this->adapter->consume($callback);
    }
}