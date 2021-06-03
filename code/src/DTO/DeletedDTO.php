<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

class DeletedDTO extends AbstractDTO
{
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = ['message' => 'deleted'];
    }
}
