<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\General\String;

class StringObject implements IStringObject
{
    private ?string $value = null;
    private int $length = 0;

    public function __construct(?string $value)
    {
        $this->value = $value;

        if (!$this->isNull()) {
            $this->length = strlen($value);
        }
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value)
    {
        $this->value = $value;

        if (!$this->isNull()) {
            $this->length = strlen($value);
        }
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function isNull(): bool
    {
        if (is_null($this->value)) {
            return true;
        }

        return false;
    }

    public function isEmpty(): bool
    {
        if ($this->length == 0) {
            return true;
        }

        return false;
    }
}
