<?php

declare(strict_types=1);

namespace App\Model\BankAccount\Repository;

use App\Model\BankAccount\Entity\AccountId;
use App\Model\BankAccount\Entity\BankAccount;
use App\Model\BankAccount\Entity\Email;

class ArrayBankAccountRepository implements BankAccountRepositoryInterface
{
    public function getOne(AccountId $id): BankAccount
    {
        $data = [
            'id'    => $id->getValue(),
            'name'  => 'Tester',
            'email' => 'tester@mail.ru',
        ];

        return $this->buildBankAccount($data);
    }

    private function buildBankAccount(array $data): BankAccount
    {
        $bankAccount = new BankAccount(new AccountId($data['id']), $data['name']);

        $bankAccount->changeEmail(new Email($data['email']));

        return $bankAccount;
    }

}