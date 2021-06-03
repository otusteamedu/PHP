<?php


namespace App\DTO;

use App\Entity\User;
use Fig\Http\Message\StatusCodeInterface;


final class UsersDTO extends AbstractDTO
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
}
