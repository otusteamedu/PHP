<?php


namespace AYakovlev\cli\Sender;


use AYakovlev\cli\Rabbitmq;

class WorkerSender extends Rabbitmq
{
    public function sendMessageToQueue(string $data, string $template): void
    {
        parent::sendMessageToQueue($data, $template);
    }
}
