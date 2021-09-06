<?php

namespace App\Repository\Postgres;


use PDO;


class PostgresPdoReadRepository
{
    /**
     * Коннектор для сервера postgres
     * @var PDO
     */
    private PDO $postgres;

    private string $query;

    public function __construct(PDO $postgres)
    {
        $this->postgres = $postgres;
        $this->query = "SELECT version();";
    }

    public function getInfo(): array
    {
        return $this->postgres
            ->query($this->query)
            ->fetch();
    }

}