<?php

declare(strict_types=1);

namespace App\Model\Event\Entity;

use InvalidArgumentException;

class Condition
{

    private string $paramName;
    private string $paramValue;

    public function __construct(string $paramName, string $paramValue)
    {
        $this->assertParamNameIsNotEmpty($paramName);

        $this->paramName = $paramName;
        $this->paramValue = $paramValue;
    }

    private function assertParamNameIsNotEmpty(string $paramName): void
    {
        if (empty($paramName)) {
            throw new InvalidArgumentException('Не указано название параметра');
        }
    }

    public function getParamName(): string
    {
        return $this->paramName;
    }

    public function getParamValue(): string
    {
        return $this->paramValue;
    }

    public function isEqual(self $otherCondition): bool
    {
        return (
            $otherCondition->getParamName() === $this->getParamName()
            and $otherCondition->getParamValue() === $this->getParamValue()
        );
    }

    public function toArray(): array
    {
        return [
            'paramName'  => $this->paramName,
            'paramValue' => $this->paramValue,
        ];
    }

}