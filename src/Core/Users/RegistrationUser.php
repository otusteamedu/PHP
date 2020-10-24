<?php

namespace App\Core\Users;

use App\Core\Users\UsersFactory\AdminUserFactory;
use App\Core\Users\UsersFactory\ClientUserFactory;
use App\Core\Users\UsersFactory\ManagerUserFactory;
use App\Core\Users\UsersFactory\User;
use App\Core\Users\UsersFactory\UserFactoryInterface;

class RegistrationUser
{
    private UserFactoryInterface $userFactory;

    /**
     * RegistrationUser constructor.
     */
    public function __construct()
    {
        $userType = $this->getUserType();
        $this->chooseUserFactory($userType);
    }

    private function getUserType(): string
    {
        return $_POST['userType'] ?? 'client';
    }

    private function chooseUserFactory(string $userType): void
    {
        switch ($userType) {
            case 'admin':
                $this->userFactory = new AdminUserFactory();
                break;
            case 'manager':
                $this->userFactory = new ManagerUserFactory();
                break;
            default:
                $this->userFactory = new ClientUserFactory();
        }
    }

    public function getUser(): User
    {
        return $this->userFactory->createUser();
    }
}