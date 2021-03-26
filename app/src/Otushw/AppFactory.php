<?php


namespace Otushw;

use Otushw\Exception\AppException;
use Otushw\ServerAPI\ServerAPI;
use Otushw\ServerQueue\ServerQueue;
use Otushw\Queue\QueueDTO;
use Otushw\Queue\QueueFactory;
use Otushw\Queue\RabbitMQ\RabbitMQFactory;

class AppFactory
{

    public function create(): AppInstanceAbstract
    {
        switch (php_sapi_name()) {
            case 'cli':
                $instance = new ServerQueue();
                break;
            case 'fpm-fcgi':
                $instance = new ServerAPI();
                break;
            default:
                throw new AppException('Unsupported server');
        }

        return $instance;
    }



}
