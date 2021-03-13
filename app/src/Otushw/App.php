<?php

namespace Otushw;

use Otushw\Queue\QueueConnectionInterface;
use Otushw\Queue\QueueInstance;

class App
{
    private QueueInstance $instance;
    private QueueConnectionInterface $queueConnection;

    public function __construct()
    {
        $this->loadConfig();
        $queue = AppFactory::create();
        $this->instance = $queue->instance;
        $this->queueConnection = $queue->queueConnection;
    }

    private function loadConfig(): void
    {
        Config::create();
    }

    public function run()
    {
        $this->instance->run();
    }
}

