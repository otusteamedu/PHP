<?php


namespace App\Entity\DTO;


use Fig\Http\Message\StatusCodeInterface;
use OpenApi\Annotations as OA;


/**
 * Class NotFoundDTO
 *
 * @OA\Schema ()
 */
final class NotFoundDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     * @OA\Property(property="message", type="string", example="Not found")
     */
    private string $message;

    /**
     * NotFoundDTO constructor.
     */
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_NOT_FOUND;
        $this->message = 'Not found';
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
