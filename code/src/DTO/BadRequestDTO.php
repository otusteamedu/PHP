<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;


final class BadRequestDTO extends AbstractDTO
{
    /**
     * TokenDTO constructor.
     */
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_BAD_REQUEST;
        $this->data = ['message' => 'Wrong data'];
    }
}
