<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

/**
 * Class RequestDTO
 *
 * @OA\Schema ()
 */
final class RequestDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var int
     * @OA\Property(property="request_number", type="int", example="22")
     */
    private int $requestNumber;

    /**
     * RequestDTO constructor.
     * @param int $requestNumber
     */
    public function __construct(int $requestNumber)
    {
        $this->requestNumber = $requestNumber;
        $this->statusCode = StatusCodeInterface::STATUS_OK;
    }


    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return ['request_number' => $this->requestNumber];
    }
}
