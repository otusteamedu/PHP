<?php


namespace Otushw;

use Otushw\Exception\AppException;
use Otushw\Queue\QueueFactory;
use Otushw\Queue\RabbitMQ\RabbitMQFactory;
use Otushw\Storage\OrderMapper;

abstract class AppInstanceAbstract
{
    protected QueueFactory $queueFactory;

    public function __construct()
    {
//        $this->queueFactory = $this->getQueueFactory();
    }

    private function getQueueFactory(): QueueFactory
    {
        switch ($_ENV['queue']['name']) {
            case 'RabbitMQ':
                return new RabbitMQFactory();
        }
        throw new AppException('Unknown queue system');
    }

    protected function isJSON(string $data): bool
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }



    abstract public function run();
}