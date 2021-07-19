<?php

declare(strict_types=1);

namespace App\Command\Request;

use App\Framework\Command\AbstractCommand;
use App\Consumer\HandleRequestConsumer;
use App\Framework\DIContainer\ContainerInterface;
use App\Service\Queue\ConsumerInterface;
use App\Service\Queue\QueueClientInterface;

class RunHandleRequestConsumerCommand extends AbstractCommand
{
    private ContainerInterface   $container;
    private QueueClientInterface $queueClient;

    public function __construct(
        ContainerInterface $container,
        QueueClientInterface $queueClient
    ) {
        $this->container = $container;
        $this->queueClient = $queueClient;
    }

    protected function fillExpectedArguments(): void
    {

    }

    protected function execute(): void
    {
        /* @var ConsumerInterface $consumer */
        $consumer = $this->container->get(HandleRequestConsumer::class);

        $this->queueClient->connect();
        $this->queueClient->subscribe('handling-requests', $consumer);

        $this->console->info('Ожидание новых запросов для обработки...');
        $this->queueClient->wait('handling-requests');

        $this->queueClient->disconnect();

        $this->console->success('Обработка запросов завершена');
    }
}