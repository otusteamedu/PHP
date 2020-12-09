<?php


namespace AYakovlev\cli;


use AYakovlev\cli\Receiver\WorkerReceiver;

class Receive extends AbstractCommand
{
    private WorkerReceiver $receiver;

    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->receiver = new WorkerReceiver();
    }

    public function execute()
    {
        $this->receiver->getMessageFromQueue();
    }

    protected function checkParams()
    {
    }
}