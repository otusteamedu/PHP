<?php


namespace App\DTO;


use Fig\Http\Message\StatusCodeInterface;


final class TokenDTO extends AbstractDTO
{
    /**
     * TokenDTO constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->statusCode = StatusCodeInterface::STATUS_OK;
        $this->data = ['token' => $token];
    }
}
