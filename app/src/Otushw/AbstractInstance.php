<?php


namespace Otushw;

use Otushw\Queue\QueueInterface;

abstract class AbstractInstance
{
    protected QueueInterface $queue;

    public function __construct(QueueInterface $queue)
    {
        $this->queue = $queue;
    }

    abstract public function run(): void;
}
