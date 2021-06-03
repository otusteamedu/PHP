<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

final class ForbiddenDTO extends AbstractDTO
{
    public function __construct()
    {
        $this->data = ['message' => 'Access denied'];
        $this->statusCode = StatusCodeInterface::STATUS_FORBIDDEN;
    }
}

