<?php


namespace App\DTO;


abstract class AbstractDTO implements InterfaceDTO
{
    protected int $statusCode;
    protected array $data;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
