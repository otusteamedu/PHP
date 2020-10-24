<?php

namespace App\Core\Users\UsersFactory;

class AdminUserFactory implements UserFactoryInterface
{

    public function createUser(): User
    {
        return new AdminUser();
    }
}