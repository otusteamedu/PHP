<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

class UpdatedDTO extends AbstractDTO
{
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = ['message' => 'updated'];
    }
}
