<?php


namespace Otushw;

use Otushw\Queue\QueueInterface;

class Producer extends AbstractInstance
{
    private string $params;

    public function __construct(QueueInterface $queue)
    {
        parent::__construct($queue);
        $this->params = $this->getParams();
    }

    private function getParams(): string
    {
        $params = new Params();
        return $params->getJSON();
    }

    public function run(): void
    {
        $this->queue->publish($this->params);
    }

}
