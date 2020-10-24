<?php

namespace App\Core\Users\UsersFactory;

interface UserFactoryInterface
{
    public function createUser(): User;
}