<?php

namespace Controllers\Contracts;

use Models\Users\User;

interface LoginInterface
{
    public function authenticate(User $user): bool;
    public function redirectUser($uri): void;
    public function logout(int $id): bool;
}