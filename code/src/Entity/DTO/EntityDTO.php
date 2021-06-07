<?php


namespace App\Entity\DTO;


use Fig\Http\Message\StatusCodeInterface;
use JsonSerializable;

class EntityDTO implements InterfaceDTO
{
    private int $statusCode;
    private JsonSerializable $data;

    /**
     * EntityDTO constructor.
     * @param int $statusCode
     * @param JsonSerializable $data
     */
    public function __construct(JsonSerializable $data, int $statusCode = StatusCodeInterface::STATUS_OK)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
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
