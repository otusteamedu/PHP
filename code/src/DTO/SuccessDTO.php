<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

class SuccessDTO extends AbstractDTO
{
    public function __construct(bool $success = true, int $statusCode = StatusCodeInterface::STATUS_OK)
    {
        $this->statusCode = $statusCode;
        $this->data = ['success' => $success];
    }
}
