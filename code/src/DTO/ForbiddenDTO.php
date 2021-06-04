<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

/**
 * Class ForbiddenDTO
 * @package App\DTO
 *
 * @OA\Schema ()
 */
final class ForbiddenDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     * @OA\Property(property="message", type="string", example="{message: Access denied}")
     */
    private string $message;

    public function __construct()
    {
        $this->message = 'Access denied';
        $this->statusCode = StatusCodeInterface::STATUS_FORBIDDEN;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }


    public function jsonSerialize(): array
    {
        return ['message' => $this->message];
    }
}

