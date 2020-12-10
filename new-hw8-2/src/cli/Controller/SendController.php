<?php


namespace AYakovlev\cli\Controller;


use AYakovlev\cli\Sender\WorkerSender;
use AYakovlev\core\AbstractCommand;

class SendController extends AbstractCommand
{
    private WorkerSender $sender;
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->sender = new WorkerSender();
    }

    protected function checkParams()
    {
        $this->ensureParamExists('d');
        $this->ensureParamExists('t');
    }

    public function execute()
    {
        $this->sender->sendMessageToQueue($this->getParam('d'), $this->getParam('t'));
    }

}