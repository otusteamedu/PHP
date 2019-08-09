<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper;

use Otus\hw22\Model\User;

interface UserMapperInterface
{
    /**
     * @param int $id
     * @return User
     */
    public function getUser(int $id): User;
}