<?php

declare(strict_types=1);

namespace App\Model\BankAccount\UseCase\Request;

use DateTimeImmutable;
use JsonSerializable;

class GenerateAccountStatementCommand implements JsonSerializable
{
    public string            $accountId;
    public DateTimeImmutable $startDate;
    public DateTimeImmutable $endDate;

    public function jsonSerialize(): array
    {
        return [
            'accountId' => $this->accountId,
            'startDate' => $this->startDate->format('c'),
            'endDate'   => $this->endDate->format('c'),
        ];
    }
}