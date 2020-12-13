<?php

namespace Controllers;

use Drivers\RabbitmqDriver;

class RuntimeServer {
    private $rabbitmq;

    public function __construct()
    {
        $this->rabbitmq = new RabbitmqDriver($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD'], $_ENV['RABBITMQ_QUEUE']);
    }

    public function startLoop() : void
    {
        $mongodb = $this->mongodb;

        $loop = function ($msg) use ($mongodb) {
            var_dump(json_decode($msg->body));
        };

        $this->rabbitmq->startLoop($loop);
    }
}
