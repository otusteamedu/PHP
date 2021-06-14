<?php

declare(strict_types=1);

namespace App\ReadModel\BankAccount;

use App\Model\BankAccount\Entity\AccountId;
use DateTimeImmutable;
use Exception;

class AccountStatementFetcher
{
    /**
     * @throws Exception
     */
    public function getByDateRange(AccountId $id, DateTimeImmutable $startDate, DateTimeImmutable $endDate): array
    {
        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'dateTransaction' => $this->randomDateBetween($startDate, $endDate)->format('d.m.Y'),
                'sum'             => random_int(-1000000, 1000000),
            ];
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    private function randomDateBetween(DateTimeImmutable $date1, DateTimeImmutable $date2): DateTimeImmutable
    {
        $start = strtotime($date1->format('c'));
        $end = strtotime($date2->format('c'));

        $timestamp = mt_rand($start, $end);

        return new DateTimeImmutable(date('c', $timestamp));
    }
}