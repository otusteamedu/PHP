<?php

declare(strict_types=1);

namespace App\Framework\Console\ExpectedArgument;

use App\Framework\Console\Argument\ArgumentTypes;
use InvalidArgumentException;

class ExpectedArgument
{
    private string $name;
    private int    $type;
    private array  $rules;
    private ?int   $number;

    public function __construct(string $name, int $type, array $rules = [])
    {
        $this->assertNameIsNotEmpty($name);
        $this->assertTypeIsExists($type);

        $this->name = $name;
        $this->type = $type;
        $this->rules = $rules;
    }

    private function assertNameIsNotEmpty(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Не указано название ожидаемого аргумента');
        }
    }

    private function assertTypeIsExists(int $type): void
    {
        if (!in_array($type, ArgumentTypes::get())) {
            throw new InvalidArgumentException('Указан некорректный тип ожидаемого аргумента');
        }
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }
}