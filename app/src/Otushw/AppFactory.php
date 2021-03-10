<?php


namespace Otushw;

use Otushw\Queue\QueueInterface;

class AppFactory
{

    public static function create(QueueInterface $queue)
    {
        switch (php_sapi_name()) {
            case 'cli':
                return new Consumer($queue);
            case 'fpm-fcgi':
                return new Producer($queue);
        }
    }
}
