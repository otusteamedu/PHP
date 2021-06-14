<?php

declare(strict_types=1);

namespace App\Provider;

use App\Framework\Console\Console;
use App\Framework\Console\ConsoleInterface;
use App\Framework\Http\Request;
use App\Framework\Http\RequestInterface;
use App\Framework\Provider\AbstractServiceProvider;
use App\Model\BankAccount\Repository\ArrayBankAccountRepository;
use App\Model\BankAccount\Repository\BankAccountRepositoryInterface;
use App\Service\Hydrator\Hydrator;
use App\Service\Hydrator\HydratorInterface;
use App\Service\Sender\Mail\MailSender;
use App\Service\Sender\SenderInterface;
use App\Service\Queue\QueueClientInterface;
use App\Service\Queue\RabbitMQ\RabbitMQQueueClient;

class AppServiceProvider extends AbstractServiceProvider
{
    protected array $bindings = [
        RequestInterface::class               => Request::class,
        ConsoleInterface::class               => Console::class,
        HydratorInterface::class              => Hydrator::class,
        QueueClientInterface::class           => RabbitMQQueueClient::class,
        SenderInterface::class                => MailSender::class,
        BankAccountRepositoryInterface::class => ArrayBankAccountRepository::class,
    ];

    protected function addMoreBindings(): void
    {

    }
}