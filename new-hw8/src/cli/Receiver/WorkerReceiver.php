<?php


namespace AYakovlev\cli\Receiver;


use AYakovlev\cli\Rabbitmq;

class WorkerReceiver extends Rabbitmq
{
    public function getMessageFromQueue(): void
    {
        parent::getMessageFromQueue();
    }
}