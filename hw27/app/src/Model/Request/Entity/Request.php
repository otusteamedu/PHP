<?php

declare(strict_types=1);

namespace App\Model\Request\Entity;

use DateTimeImmutable;
use InvalidArgumentException;
use UnexpectedValueException;

class Request
{
    private Id                $id;
    private string            $name;
    private DateTimeImmutable $creationDate;
    private int               $status;

    public function __construct(Id $id, string $name, DateTimeImmutable $creationDate)
    {
        $this->assertNameIsNotEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->creationDate = $creationDate;
        $this->status = Statuses::NOT_HANDLED;
    }

    private function assertNameIsNotEmpty(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Не указано название запроса');
        }
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function markAsHandled(): void
    {
        if ($this->isHandled()) {
            throw new UnexpectedValueException('Запрос уже обработан');
        }

        $this->status = Statuses::HANDLED;
    }

    private function isHandled(): bool
    {
        return ($this->status === Statuses::HANDLED);
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id->getValue(),
            'name'          => $this->name,
            'creation_date' => $this->creationDate->format('c'),
            'status'        => $this->status,
        ];
    }
}