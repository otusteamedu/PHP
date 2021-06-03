<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

final class EntitiesDTO extends AbstractDTO
{
    public function __construct(array $entities)
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = $entities;
    }

}
