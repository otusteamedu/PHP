<?php


namespace App\Core\Users\UsersFactory;


class ManagerUserFactory implements UserFactoryInterface
{

    public function createUser(): User
    {
        return new ManagerUser();
    }
}