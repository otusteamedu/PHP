<?php

declare(strict_types=1);

namespace App\Model\BankAccount\Entity;

use InvalidArgumentException;

class AccountId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Не указан id аккаунта');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}