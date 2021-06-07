<?php


namespace App\Entity\DTO;


use Fig\Http\Message\StatusCodeInterface;
use OpenApi\Annotations as OA;


/**
 * Class SuccessDTO
 * @package App\DTO
 *
 * @OA\Schema ()
 */
class SuccessDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var bool
     * @OA\Property(property="success", type="bool", example="true")
     */
    private bool $success;

    public function __construct(bool $success = true, int $statusCode = StatusCodeInterface::STATUS_OK)
    {
        $this->success = $success;
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function jsonSerialize(): array
    {
        return ['success' => $this->success];
    }
}
