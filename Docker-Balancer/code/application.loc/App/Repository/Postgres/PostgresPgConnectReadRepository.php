<?php

namespace App\Repository\Postgres;

class PostgresPgConnectReadRepository
{
    /**
     * Коннектор для сервера Postgres
     * @var mixed
     */
    private mixed $postgres;

    private string $query;

    public function __construct(mixed $postgres)
    {
        $this->postgres = $postgres;
        $this->query = "SELECT version();";
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        $result = pg_query($this->postgres, $this->query);
        return pg_fetch_row($result);
    }

    /**
     * Преобразование данных запроса в массив
     *
     * @param mysqli_result $result
     * @return array
     */
    private function fetchAll(mysqli_result $result): array
    {
        $fetchedRows = [];
        while ($row = $result->fetch_object()){
            $fetchedRows[] = $row;
        }
        return $fetchedRows;
    }

}