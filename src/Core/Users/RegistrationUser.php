<?php

namespace App\Core\Users;

use App\Core\Users\UsersFactory\AdminUserFactory;
use App\Core\Users\UsersFactory\ClientUserFactory;
use App\Core\Users\UsersFactory\ManagerUserFactory;
use App\Core\Users\UsersFactory\User;
use App\Core\Users\UsersFactory\UserFactoryInterface;
use ErrorException;

class RegistrationUser
{
    private const USER_TYPE_ADMIN = 'admin';
    private const USER_TYPE_MANAGER = 'manager';
    private const USER_TYPE_CLIENT = 'client';

    private UserFactoryInterface $userFactory;

    /**
     * RegistrationUser constructor.
     * @param string $userType
     * @throws ErrorException
     */
    public function __construct(string $userType)
    {
        $this->chooseUserFactory($userType);
    }

    /**
     * @param string $userType
     * @throws ErrorException
     */
    private function chooseUserFactory(string $userType): void
    {
        switch ($userType) {
            case static::USER_TYPE_ADMIN:
                $this->userFactory = new AdminUserFactory();
                break;
            case static::USER_TYPE_MANAGER:
                $this->userFactory = new ManagerUserFactory();
                break;
            case static::USER_TYPE_CLIENT:
                $this->userFactory = new ClientUserFactory();
                break;
            default:
                throw new ErrorException('the user type is invalid');
        }
    }

    public function getUser(): User
    {
        return $this->userFactory->createUser();
    }
}