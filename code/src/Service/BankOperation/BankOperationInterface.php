<?php


namespace App\Service\BankOperation;


use App\Entity\BankOperation;
use App\Entity\User;
use DateTime;

interface BankOperationInterface
{
    public function getUserFirstOperation(User $user): ?BankOperation;
    public function getUserOperations(User $user, DateTime $dateStart, DateTime $dateEnd): bool;
}
