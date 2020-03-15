<?php declare(strict_types=1);

namespace Entity\Shop;

class Discount
{
    private int $id;

    private string $promocode;

    private int $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPromocode(): string
    {
        return $this->promocode;
    }

    public function setPromocode(string $promocode): void
    {
        $this->promocode = $promocode;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
