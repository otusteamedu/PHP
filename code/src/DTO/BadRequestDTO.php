<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;


/**
 * Class BadRequestDTO
 * @package App\DTO
 *
 * @OA\Schema ()
 */
final class BadRequestDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     * @OA\Property(property="message", type="string", example="{message: Wrong data}")
     */
    private string $message;
    /**
     * TokenDTO constructor.
     */
    public function __construct()
    {
        $this->statusCode = StatusCodeInterface::STATUS_BAD_REQUEST;
        $this->message = 'Wrong data';
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function jsonSerialize()
    {
        return ['message' => $this->message];
    }
}
