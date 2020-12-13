<?php

namespace Controllers;

use Drivers\MongodbDriver;
use Drivers\RabbitmqDriver;

class RuntimeServer {
    private $mongodb;
    private $rabbitmq;

    public function __construct()
    {
        $this->mongodb = new MongodbDriver($_ENV['MONGODB_DSN'], $_ENV['MONGODB_DATABASE'], $_ENV['MONGODB_COLLECTION']);
        $this->rabbitmq = new RabbitmqDriver($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD'], $_ENV['RABBITMQ_QUEUE']);
    }

    public function startLoop() : void
    {
        $mongodb = $this->mongodb;

        $loop = function ($msg) use ($mongodb) {
            $mongodb->update($msg->body, ['status' => true]);
            echo 'done: ' . $msg->body . "\n\n";
        };

        $this->rabbitmq->startLoop($loop);
    }
}
