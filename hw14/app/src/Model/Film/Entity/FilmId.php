<?php

declare(strict_types=1);

namespace App\Model\Film\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class FilmId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Не указан id фильма');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid1()->toString());
    }
}