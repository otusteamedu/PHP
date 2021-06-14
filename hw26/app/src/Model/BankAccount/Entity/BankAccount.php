<?php

declare(strict_types=1);

namespace App\Model\BankAccount\Entity;

use InvalidArgumentException;

class BankAccount
{
    private AccountId $id;
    private string    $name;
    private ?Email    $email;

    public function __construct(AccountId $id, string $name)
    {
        $this->assertNameIsNotEmpty($name);

        $this->id = $id;
        $this->name = $name;
    }

    private function assertNameIsNotEmpty(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Не указано имя пользователя');
        }
    }

    public function getId(): AccountId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }
}