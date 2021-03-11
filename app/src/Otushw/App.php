<?php

namespace Otushw;

use Otushw\Exception\AppException;
use Otushw\Queue\QueueInterface;
use Otushw\Queue\RabbitMQ;

class App
{
    private AbstractInstance $instance;

    public function __construct()
    {
        $this->loadConfig();
        $this->instance = AppFactory::create($this->getQueue());
    }

    private function loadConfig(): void
    {
        Config::create();
    }

    private function getQueue(): ?QueueInterface
    {
        switch ($_ENV['queue']['name']) {
            case 'RabbitMQ':
                return new RabbitMQ();
        }
        throw new AppException('Unknown queue system');
    }

    public function run()
    {
        $this->instance->run();
    }
}

