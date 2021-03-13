<?php


namespace Otushw;

use Otushw\Exception\AppException;
use Otushw\Queue\QueueDTO;
use Otushw\Queue\QueueFactory;
use Otushw\Queue\RabbitMQ\RabbitMQFactory;

class AppFactory
{

    public static function create(): QueueDTO
    {
        $factory = self::getQueueFactory();
        $queueConnection = $factory->createConnection();
        switch (php_sapi_name()) {
            case 'cli':
                $instance = $factory->createConsumer($queueConnection);
                break;
            case 'fpm-fcgi':
                $instance = $factory->createProducer($queueConnection, self::getParams());
                break;
            default:
                throw new AppException('Unsupported server');
        }

        return new QueueDTO($queueConnection, $instance);
    }

    private static function getQueueFactory(): QueueFactory
    {
        switch ($_ENV['queue']['name']) {
            case 'RabbitMQ':
                return new RabbitMQFactory();
        }
        throw new AppException('Unknown queue system');
    }

    private static function getParams(): string
    {
        $params = new Params();
        return $params->getJSON();
    }

}
