<?php

declare(strict_types=1);

namespace App\Model\Film\Entity;

use InvalidArgumentException;

class Film
{
    private FilmId $id;
    private string $name;
    private int    $productionYear;

    public function __construct(FilmId $id, string $name)
    {
        $this->assertNameIsNotEmpty($name);

        $this->id = $id;
        $this->name = $name;
    }

    private function assertNameIsNotEmpty(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Не указано название фильма');
        }
    }

    public function changeName(string $name): void
    {
        $this->assertNameIsNotEmpty($name);

        $this->name = $name;
    }

    public function changeProductionYear(int $productionYear): void
    {
        $this->productionYear = $productionYear;
    }

    public function getId(): FilmId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductionYear(): int
    {
        return $this->productionYear;
    }

    public function toArray(): array
    {
        return [
            'id'              => $this->id->getValue(),
            'name'            => $this->name,
            'production_year' => $this->productionYear,
        ];
    }
}