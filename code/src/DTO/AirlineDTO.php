<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

class AirlineDTO implements InterfaceDTO
{
    private int $statusCode;
    private \JsonSerializable $data;

    /**
     * AirlineDTO constructor.
     * @param int $statusCode
     * @param \JsonSerializable $data
     */
    public function __construct(\JsonSerializable $data, int $statusCode = StatusCodeInterface::STATUS_OK)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }


    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData()
    {
        return $this->data;
    }
}
