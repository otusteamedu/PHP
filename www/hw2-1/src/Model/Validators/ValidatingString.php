<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators;

class ValidatingString
{
    private ?string $value = null;
    private int $length = 0;

    public function __construct(?string $value)
    {
        $this->value = $value;
        $this->length = strlen($value);
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    protected function isEmpty(): bool
    {
        if ($this->length == 0) {
            return true;
        }

        return false;
    }

    protected function isLengthEven(): bool
    {
        if ($this->length % 2 == 0) {
            return true;
        }

        return false;
    }

}
