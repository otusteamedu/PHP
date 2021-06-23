<?php

declare(strict_types=1);

namespace App\Model\BankAccount\Repository;

use App\Model\BankAccount\Entity\AccountId;
use App\Model\BankAccount\Entity\BankAccount;

interface BankAccountRepositoryInterface
{
    public function getOne(AccountId $id): BankAccount;
}