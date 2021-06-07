<?php


namespace App\Entity\DTO;


use Fig\Http\Message\StatusCodeInterface;


final class EntitiesDTO implements InterfaceDTO
{
    private int $statusCode;
    private array $data;

    public function __construct(array $entities)
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = $entities;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
