<?php

declare(strict_types=1);

namespace App\Command\BankAccount;

use App\Framework\Command\CommandInterface;
use App\Framework\Console\ConsoleInterface;
use App\Consumer\GenerateAccountStatementConsumer;
use App\Framework\DIContainer\ContainerInterface;
use App\Service\Queue\ConsumerInterface;
use App\Service\Queue\QueueClientInterface;

class RunGenerateStatementConsumerCommand implements CommandInterface
{
    private ContainerInterface   $container;
    private ConsoleInterface     $console;
    private QueueClientInterface $queueClient;

    public function __construct(
        ContainerInterface $container,
        ConsoleInterface $console,
        QueueClientInterface $queueClient
    ) {
        $this->container = $container;
        $this->console = $console;
        $this->queueClient = $queueClient;
    }

    public function execute(): void
    {
        /* @var ConsumerInterface $consumer */
        $consumer = $this->container->get(GenerateAccountStatementConsumer::class);

        $this->queueClient->connect();
        $this->queueClient->subscribe('GenerateAccountStatement', $consumer);

        $this->console->info('Ожидание новых запросов на формирование выписки...');
        $this->queueClient->wait('GenerateAccountStatement');

        $this->queueClient->disconnect();

        $this->console->success('Обработка запросов завершена');
    }
}