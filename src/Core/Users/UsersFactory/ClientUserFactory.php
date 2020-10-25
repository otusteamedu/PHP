<?php

namespace App\Core\Users\UsersFactory;

class ClientUserFactory implements UserFactoryInterface
{

    public function createUser(): User
    {
        return new ClientUser();
    }
}