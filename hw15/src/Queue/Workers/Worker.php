<?php


namespace App\Queue\Workers;


use App\Queue\QueueBroker;

class Worker
{
    /**
     * @var QueueBroker
     */
    protected $broker;

    public function __construct(QueueBroker $broker)
    {
        $this->broker = $broker;
    }


}