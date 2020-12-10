<?php


namespace AYakovlev\cli\Controller;


use AYakovlev\cli\Receiver\WorkerReceiver;
use AYakovlev\core\AbstractCommand;

class ReceiveController extends AbstractCommand
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