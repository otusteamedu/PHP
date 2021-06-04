<?php


namespace App\DTO;

use App\Entity\User;
use Fig\Http\Message\StatusCodeInterface;


/**
 * Class UsersDTO
 * @package App\DTO
 */
final class UsersDTO implements InterfaceDTO
{
    /**
     * UsersDTO constructor.
     *
     * @param User[] $users
     */
    public function __construct(array $users)
    {
        $this->data = $users;
        $this->statusCode = StatusCodeInterface::STATUS_OK;
    }

    public function getStatusCode(): int
    {
        // TODO: Implement getStatusCode() method.
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
