<?php

declare(strict_types=1);

namespace App\Model\Event\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class EventId
{

    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Не указан id события');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

}