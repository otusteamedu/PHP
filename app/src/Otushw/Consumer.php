<?php


namespace Otushw;

use Otushw\Queue\QueueInterface;

class Consumer extends AbstractInstance
{
    public function __construct(QueueInterface $queue)
    {
        parent::__construct($queue);
    }

    public function run(): void
    {
        $this->queue->consume();
    }
}
