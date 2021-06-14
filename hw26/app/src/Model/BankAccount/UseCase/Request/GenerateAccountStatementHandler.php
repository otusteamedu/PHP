<?php

declare(strict_types=1);

namespace App\Model\BankAccount\UseCase\Request;

use App\Service\Queue\QueueClientInterface;
use DateTimeImmutable;
use InvalidArgumentException;

class GenerateAccountStatementHandler
{
    private QueueClientInterface $queueClient;

    public function __construct(QueueClientInterface $queueClient)
    {
        $this->queueClient = $queueClient;
    }

    public function handle(GenerateAccountStatementCommand $command): void
    {
        $this->throwExceptionIfStartDateIsGreaterThanEndDate($command->startDate, $command->endDate);

        $this->queueClient->connect();

        $this->queueClient->publish('GenerateAccountStatement', $command);

        $this->queueClient->disconnect();
    }

    private function throwExceptionIfStartDateIsGreaterThanEndDate(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ): void {
        if ($startDate > $endDate) {
            throw new InvalidArgumentException('Некорректно указан период');
        }
    }
}