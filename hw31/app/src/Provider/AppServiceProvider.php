<?php

declare(strict_types=1);

namespace App\Provider;

use App\Framework\Console\Console;
use App\Framework\Console\ConsoleInterface;
use App\Framework\Database\DbConnectionBuilder;
use App\Framework\Http\Request;
use App\Framework\Http\RequestInterface;
use App\Framework\Provider\AbstractServiceProvider;
use App\Model\Request\Repository\PostgresqlRequestRepository;
use App\Model\Request\Repository\RequestRepositoryInterface;
use App\Service\Hydrator\Hydrator;
use App\Service\Hydrator\HydratorInterface;
use App\Service\Queue\QueueClientInterface;
use App\Service\Queue\RabbitMQ\RabbitMQQueueClient;
use PDO;

class AppServiceProvider extends AbstractServiceProvider
{
    protected array $bindings = [
        RequestInterface::class           => Request::class,
        ConsoleInterface::class           => Console::class,
        HydratorInterface::class          => Hydrator::class,
        QueueClientInterface::class       => RabbitMQQueueClient::class,
        RequestRepositoryInterface::class => PostgresqlRequestRepository::class,
    ];

    protected function addMoreBindings(): void
    {
        $this->addBindDbConnection();
    }

    private function addBindDbConnection(): void
    {
        $this->bindings[PDO::class] = function () {
            return (new DbConnectionBuilder())
                ->setDriver(getenv('DB_DRIVER'))
                ->setHost(getenv('DB_HOST'))
                ->setPort(intval(getenv('DB_PORT')))
                ->setDbName(getenv('DB_NAME'))
                ->setUserName(getenv('DB_USERNAME'))
                ->setPassword(getenv('DB_PASSWORD'))
                ->build();
        };
    }
}