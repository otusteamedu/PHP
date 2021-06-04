<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;

/**
 * Class TokenDTO
 * @package App\DTO
 *
 * @OA\Schema ()
 */
final class TokenDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     * @OA\Property(property="token", type="string", example="c16e40fa31e1c99849c0")
     */
    private string $token;


    /**
     * TokenDTO constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->token = $token;
    }

    public function getStatusCode(): int
    {
        return $this->token;
    }

    public function jsonSerialize(): array
    {
        return ['token' => $this->token];
    }
}
