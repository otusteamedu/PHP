<?php

declare(strict_types=1);

namespace App\Model\BankAccount\Entity;

use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertEmailIsNotEmpty($value);
        $this->assertEmailIsValid($value);

        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertEmailIsNotEmpty(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Не указан email');
        }
    }

    private function assertEmailIsValid(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректно указан email');
        }
    }
}