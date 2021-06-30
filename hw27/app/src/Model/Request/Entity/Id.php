<?php

declare(strict_types=1);

namespace App\Model\Request\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class Id
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Не указан id запроса');
        }

        $this->value = $value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}