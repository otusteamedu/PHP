<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

final class AirlinesDTO extends AbstractDTO
{
    public function __construct(array $airlines)
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = $airlines;
    }

}
