<?php


namespace App\Api;


use App\Amqp\Rabbit;
use App\Api\Handlers\ErrorHandler;
use App\Api\Handlers\Handler;
use App\Api\Handlers\RequestRegistrationHandler;
use App\Api\Handlers\StatusReaderHandler;
use App\Queue\Workers\ClientWorker;
use App\Queue\QueueBroker;

class Api
{
    /** @var QueueBroker */
    private $broker;

    public function __construct()
    {
        $this->broker = Rabbit::create();
    }

    public function run()
    {
        $handler = $this->buildHandler();

        if (!$handler)
            $handler = new ErrorHandler(ErrorHandler::ERR_SERVER);

        return $handler->output();
    }

    /**
     * @return Handler|null
     */
    private function buildHandler()
    {
        $handler = null;

        if ($this->broker) {

            $clientWorker = new ClientWorker($this->broker);

            if ($this->isRouteRequest())
                $handler = new RequestRegistrationHandler($clientWorker);
            elseif ($this->isRouteGetStatus())
                $handler = new StatusReaderHandler($clientWorker);
            else
                $handler = new ErrorHandler(ErrorHandler::ERR_CMD);
        }

        return $handler;
    }

    private function isRouteRequest()
    {
        //some logic
        return false;
    }

    private function isRouteGetStatus()
    {
        //some logic
        return true;
    }
}
