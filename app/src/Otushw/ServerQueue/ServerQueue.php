<?php


namespace Otushw\ServerQueue;

use Otushw\Queue\QueueConsumerInterface;
use Otushw\AppInstanceAbstract;

class ServerQueue extends AppInstanceAbstract
{
    protected QueueConsumerInterface $queueConsumer;

    public function __construct()
    {
        parent::__construct();
        $this->queueConsumer = $this->queueFactory->createConsumer();
    }
}